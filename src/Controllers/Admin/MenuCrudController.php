<?php

namespace Ophim\Core\Controllers\Admin;

use Ophim\CoreHttp\Requests\MenuRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Ophim\Core\Models\Menu;

/**
 * Class MenuCrudController
 * @package Ophim\CoreHttp\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MenuCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        $this->crud->setModel(Menu::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/menu');
        $this->crud->setEntityNameStrings('menu item', 'menu items');

        $this->crud->enableReorder('name', 2);

        $this->crud->operation('list', function () {
            $this->crud->addColumn([
                'name' => 'name',
                'label' => 'Label',
            ]);
            $this->crud->addColumn([
                'label' => 'Parent',
                'type' => 'select',
                'name' => 'parent_id',
                'entity' => 'parent',
                'attribute' => 'name',
                'model' => Menu::class,
            ]);
            $this->crud->addColumn([
                'name' => 'link',
                'label' => 'Link',
                'type' => 'url',
            ]);
        });

        $this->crud->operation(['create', 'update'], function () {
            $this->crud->addField([
                'name' => 'name',
                'label' => 'Label',
            ]);
            $this->crud->addField([
                'label' => 'Parent',
                'type' => 'select',
                'name' => 'parent_id',
                'entity' => 'parent',
                'attribute' => 'name',
                Menu::class
            ]);

            $this->crud->addField([
                'name' => ['type', 'link', 'internal_link'],
                'label' => 'Type',
                'type' => 'page_or_link',
            ]);
        });
    }
}
