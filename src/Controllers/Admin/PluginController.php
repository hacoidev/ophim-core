<?php

namespace Ophim\Core\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Ophim\Core\Models\Plugin;
use Prologue\Alerts\Facades\Alert;

class PluginController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Plugin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin');
        CRUD::setEntityNameStrings('plugin', 'plugins');
        $this->crud->denyAccess('update');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (!backpack_user()->hasPermissionTo('Browse plugin')) {
            abort(403);
        }

        CRUD::column('name')->label('Plugin')->type('text');
        CRUD::column('version')->label('Version')->type('text');
        $this->crud->addButtonFromModelFunction('line', 'editBtn', 'editBtn', 'beginning');
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
        Route::get($segment . '/{id}/edit', [
            'as'        => $routeName . '.edit',
            'uses'      => $controller . '@edit',
            'operation' => 'update',
        ]);

        Route::put($segment . '/{id}', [
            'as'        => $routeName . '.update',
            'uses'      => $controller . '@update',
            'operation' => 'update',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        if (!backpack_user()->hasPermissionTo('Update plugin')) {
            abort(403);
        }

        $this->data['entry'] = $this->crud->getEntryWithLocale($id);

        $plugins = collect(config('plugins', []));

        $plugin = $plugins->filter(function ($v, $k) {
            return 'plugins.' . strtolower($v['name']) . '.options' === $this->data['entry']->key;
        })->first();

        if (isset($plugin['options']) && is_array($plugin['options'])) {
            CRUD::addField(['name' => 'fields', 'type' => 'hidden', 'value' => collect($plugin['options'])->implode('name', ',')]);

            foreach ($plugin['options'] as $field) {
                CRUD::addField($field);
            }
        }

        $this->crud->setOperationSetting('fields', $this->getUpdateFields());

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit') . ' ' . $this->crud->entity_name;
        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/hacoidev/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
    }

    /**
     * Update the specified resource in the database.
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function update($plugin)
    {
        if (!backpack_user()->hasPermissionTo('Update plugin')) {
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

        // show a success message
        Alert::success(trans('backpack::crud.update_success'))->flash();

        return redirect(backpack_url('plugin'));
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
}
