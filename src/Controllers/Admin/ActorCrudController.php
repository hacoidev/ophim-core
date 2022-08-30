<?php

namespace Ophim\Core\Controllers\Admin;

use Ophim\Core\Requests\ActorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Ophim\Core\Models\Actor;

/**
 * Class ActorCrudController
 * @package Ophim\Core\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ActorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Ophim\Core\Models\Actor::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/actor');
        CRUD::setEntityNameStrings('actor', 'actors');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->authorize('browse', Actor::class);

        CRUD::addColumn(['name' => 'name', 'label' => 'Tên', 'type' => 'text']);
        CRUD::addColumn(['name' => 'slug', 'label' => 'Đường dẫn tĩnh', 'type' => 'text']);
        CRUD::addColumn(['name' => 'gender', 'label' => 'Giới tính', 'type' => 'text']);
        CRUD::addColumn(['name' => 'image', 'label' => 'Ảnh', 'type' => 'image']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->authorize('create', Actor::class);

        CRUD::setValidation(ActorRequest::class);

        CRUD::addField(['name' => 'name', 'label' => 'Tên', 'type' => 'text']);
        CRUD::addField(['name' => 'slug', 'label' => 'Đường dẫn tĩnh', 'type' => 'text']);
        CRUD::addField(['name' => 'image', 'label' => 'Ảnh', 'type' => 'upload']);
        CRUD::addField([
            'name'        => 'gender',
            'label'       => "Giới tính",
            'type'        => 'select_from_array',
            'options'     => ['male' => 'Nam', 'female' => 'Nữ', 'other' => 'Khác'],
            'allows_null' => false,
            'default'     => 'one',
        ],);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->authorize('update', $this->crud->getEntryWithLocale($this->crud->getCurrentEntryId()));

        $this->setupCreateOperation();
    }

    protected function setupDeleteOperation()
    {
        $this->authorize('delete', $this->crud->model);
    }
}
