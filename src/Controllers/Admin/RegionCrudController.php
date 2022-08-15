<?php

namespace Ophim\Core\Controllers\Admin;

use Ophim\Core\Requests\RegionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Ophim\Core\Models\Region;

/**
 * Class RegionCrudController
 * @package Ophim\Core\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RegionCrudController extends CrudController
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
        CRUD::setModel(\Ophim\Core\Models\Region::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/region');
        CRUD::setEntityNameStrings('region', 'regions');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->authorize('browse', Region::class);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->label('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        CRUD::column('name')->label('Tên khu vực')->type('text');
        CRUD::column('slug')->label('Đường dẫn tĩnh')->type('text');
        CRUD::column('seo_title')->label('SEO Title')->type('text');
        CRUD::column('seo_des')->label('SEO Description')->type('text');
        CRUD::column('seo_key')->label('SEO Keyword')->type('text');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->authorize('create', Region::class);

        CRUD::setValidation(RegionRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->label('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
        CRUD::field('name')->label('Tên khu vực')->type('text');
        CRUD::field('slug')->label('Đường dẫn tĩnh')->type('text');
        CRUD::field('seo_title')->label('SEO Title')->type('text');
        CRUD::field('seo_des')->label('SEO Description')->type('textarea');
        CRUD::field('seo_key')->label('SEO Keyword')->type('text');
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
        $this->authorize('delete', $this->crud->getEntryWithLocale($this->crud->getCurrentEntryId()));
    }
}
