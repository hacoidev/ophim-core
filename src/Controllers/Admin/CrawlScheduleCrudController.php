<?php

namespace Ophim\Core\Controllers\Admin;

use App\Http\Requests\CrawlScheduleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Ophim\Core\Models\Category;

/**
 * Class CrawlScheduleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CrawlScheduleCrudController extends CrudController
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
        CRUD::setModel(\App\Models\CrawlSchedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/crawl-schedule');
        CRUD::setEntityNameStrings('crawl schedule', 'crawl schedules');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

        CRUD::addColumn(['name' => 'type', 'label' => 'Type', 'type' => 'text']);
        CRUD::addColumn(['name' => 'link', 'label' => 'Link', 'type' => 'text']);
        CRUD::addColumn(['name' => 'fields', 'label' => 'Fields', 'type' => 'text']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CrawlScheduleRequest::class);



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */

        CRUD::addField(['name' => 'type', 'label' => 'Type', 'type' => 'text', 'tab' => 'Nguồn phim']);
        CRUD::addField(['name' => 'link', 'label' => 'Link', 'type' => 'text', 'tab' => 'Nguồn phim']);
        CRUD::addField(['name' => 'fields', 'label' => 'Fields', 'type' => 'text', 'tab' => 'Nguồn phim']);
        CRUD::addField([
            'name' => 'excldue_categories', 'label' => 'Loại trừ thể loại', 'type' => 'text',
            'tab' => 'Nguồn phim'
        ]);
        CRUD::addField([
            'name' => 'excldue_regions', 'label' => 'Loại trừ quốc gia', 'type' => 'text',
            'tab' => 'Nguồn phim'
        ]);

        CRUD::addField(['name' => 'from_page', 'label' => 'Từ trang', 'type' => 'number', 'default' => 1, 'tab' => 'Nguồn phim']);
        CRUD::addField(['name' => 'to_page', 'label' => 'Đến trang', 'type' => 'number', 'default' => 1, 'tab' => 'Nguồn phim']);

        CRUD::addField(['name' => 'at_month', 'label' => 'Tháng', 'type' => 'text', 'tab' => 'Thời gian chạy']);
        CRUD::addField(['name' => 'at_week', 'label' => 'Tuần', 'type' => 'text', 'tab' => 'Thời gian chạy']);
        CRUD::addField(['name' => 'at_day', 'label' => 'Ngày', 'type' => 'text', 'tab' => 'Thời gian chạy']);
        CRUD::addField(['name' => 'at_hour', 'label' => 'Giờ', 'type' => 'text', 'tab' => 'Thời gian chạy']);
        CRUD::addField(['name' => 'at_minute', 'label' => 'Phút', 'type' => 'text', 'tab' => 'Thời gian chạy']);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
