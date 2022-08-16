<?php

namespace Ophim\Core\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\Settings\app\Models\Setting;
use Illuminate\Support\Facades\Route;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

class CustomizerController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Setting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customizer');
        CRUD::setEntityNameStrings('theme customizer', 'theme customizer');
    }

    /**
     * Define which routes are needed for this operation.
     *
     * @param  string  $name  Name of the current entity (singular). Used as first URL segment.
     * @param  string  $routeName  Prefix of the route name.
     * @param  string  $controller  Name of the current CrudController.
     */
    protected function setupUpdateRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/', [
            'as'        => $routeName . '.edit',
            'uses'      => $controller . '@edit',
            'operation' => 'update',
        ]);

        Route::put($segment . '/{id}', [
            'as'        => $routeName . '.update',
            'uses'      => $controller . '@update',
            'operation' => 'update',
        ]);

        Route::post($segment . '/{id}/reset', [
            'as'        => $routeName . '.reset',
            'uses'      => $controller . '@reset',
            'operation' => 'update',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        if (!backpack_user()->hasPermissionTo('Customize theme')) {
            abort(403);
        }

        $theme = Setting::get('site.theme') ?? config('ophim.theme', 'default');

        $id = Setting::firstOrCreate([
            'key' => 'themes.' . strtolower($theme) . '.customize',
        ], [
            'name' => "{$theme}\'s customizer",
            'field' => json_encode(['name' => 'value', 'type', 'hidden']),
            'active' => false
        ])->id;

        $this->data['entry'] = $this->crud->getEntryWithLocale($id);
        $this->crud->setOperationSetting('fields', $this->getUpdateFields());

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit') . ' ' . $this->crud->entity_name;
        $this->data['id'] = $id;

        return view('ophim::customizer', $this->data);
    }

    /**
     * Update the specified resource in the database.
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        if (!backpack_user()->hasPermissionTo('Customize theme')) {
            abort(403);
        }

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        // update the row in the db
        $item = $this->crud->update(
            $request->get($this->crud->model->getKeyName()),
            [
                'value' => json_encode(request()->only(explode(',', request('fields'))))
            ]
        );

        $this->data['entry'] = $this->crud->entry = $item;

        Alert::success(trans('backpack::crud.update_success'))->flash();

        return redirect(backpack_url('customizer'));
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $theme = Setting::get('site.theme') ?? config('ophim.theme', 'default');

        $fields = config('themes.' . $theme . '.options', []);

        CRUD::addField(['name' => 'fields', 'type' => 'hidden', 'value' => collect($fields)->implode('name', ',')]);

        foreach ($fields as $field) {
            CRUD::addField($field);
        }

        $this->data['reset_form'] = $this->getResetFormHTML($theme);
    }

    /**
     * Get all fields needed for the EDIT ENTRY form.
     *
     * @param  int  $id  The id of the entry that is being edited.
     * @return array The fields with attributes, fake attributes and values.
     */
    public function getUpdateFields($id = false)
    {
        $fields = $this->crud->fields();
        $entry = ($id != false) ? $this->getEntry($id) : $this->crud->getCurrentEntry();
        $options = json_decode($entry->value, true) ?? [];

        foreach ($options as $k => $v) {
            $fields[$k]['value'] = $v;
        }

        if (!array_key_exists('id', $fields)) {
            $fields['id'] = [
                'name'  => $entry->getKeyName(),
                'value' => $entry->getKey(),
                'type'  => 'hidden',
            ];
        }

        return $fields;
    }

    public function reset(Request $request, $id)
    {
        $setting = Setting::fromCache()->findByKey('id', $id);

        if (is_null($setting)) {
            Alert::warning("Không tìm thấy dữ liệu giao diện")->flash();
            return redirect(backpack_url('customizer'));
        }

        $theme = Setting::get('site.theme') ?? config('ophim.theme', 'default');

        $fields = collect(config('themes.' . $theme . '.options', []));

        $setting->update([
            'value' => $fields->pluck('value', 'name')->toArray()
        ]);

        Alert::success(trans('backpack::crud.update_success'))->flash();

        return redirect(backpack_url('customizer'));
    }

    protected function getResetFormHTML($theme)
    {
        $setting = Setting::fromCache()->find('themes.' . strtolower($theme) . '.customize');

        if (is_null($setting)) {
            return;
        }

        $template = <<<EOT
        <form action="{actionRoute}" method="post" onsubmit="return confirm('Chắc chắn muốn đặt về mặc định?');">
            {csrfField}
            <button class="btn btn-secondary" type="submit">{name}</button>
        </form>
        EOT;


        $html = str_replace("{actionRoute}", route('customizer.reset', $setting->id), $template);
        $html = str_replace("{csrfField}", csrf_field(), $html);
        $html = str_replace("{name}", 'Reset to default', $html);

        return $html;
    }
}
