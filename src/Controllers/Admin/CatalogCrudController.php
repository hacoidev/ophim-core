<?php

namespace Ophim\Core\Controllers\Admin;

use Ophim\Core\Requests\CatalogRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Ophim\Core\Models\Catalog;

/**
 * Class CatalogCrudController
 * @package Ophim\Core\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CatalogCrudController extends CrudController
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
        CRUD::setModel(\Ophim\Core\Models\Catalog::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/catalog');
        CRUD::setEntityNameStrings('catalog', 'catalogs');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->authorize('browse', Catalog::class);

        CRUD::addButtonFromModelFunction('line', 'open_view', 'openView', 'beginning');

        CRUD::column('name')->label('Tên')->type('text');
        CRUD::column('slug')->label('Đường dẫn tĩnh')->type('text');
        CRUD::column('paginate')->label('Item per page')->type('number');
        CRUD::column('value')->label('Value')->type('text');
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
        $this->authorize('create', Catalog::class);

        CRUD::setValidation(CatalogRequest::class);

        CRUD::field('name')->label('Tên')->type('text');
        CRUD::field('slug')->label('Đường dẫn tĩnh')->type('text');
        CRUD::field('paginate')->label('Paginate')->hint('Item per page')->type('number');
        CRUD::field('value')->label('Value')->hint('relation_tables,relation_field,relation_value|find_by_field_1,find_by_fiel_2,...,find_by_field_n|value_1,value_2,...,value_n|sort_by_field|sort_algo')->type('text');
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
