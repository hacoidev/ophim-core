<?php

namespace Ophim\Core\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Settings\app\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\CrawlSchedule;
use Ophim\Core\Requests\CrawlScheduleRequest;

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
        CRUD::setModel(\Ophim\Core\Models\CrawlSchedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/crawl-schedule');
        CRUD::setEntityNameStrings('lịch cập nhật', 'danh sách lịch cập nhật');
        $this->crud->denyAccess('show');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->authorize('browse', CrawlSchedule::class);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

        CRUD::addColumn(['name' => 'handler', 'label' => 'Handler', 'type' => 'text']);
        CRUD::addColumn(['name' => 'link', 'label' => 'Link', 'type' => 'text']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->authorize('create', CrawlSchedule::class);

        CRUD::setValidation(CrawlScheduleRequest::class);

        CRUD::addField(['name' => 'type', 'label' => 'Handler', 'type' => 'select_from_array', 'options' => config('ophim.crawlers', []), 'tab' => 'Nguồn phim']);
        CRUD::addField([
            'name' => 'link',
            'label' => 'Link',
            'type' => 'textarea',
            'attributes' => [
                'rows' => 5
            ],
            'hint' => 'Mỗi link cách nhau 1 dòng',
            'default' => 'https://ophim1.com/danh-sach/phim-moi-cap-nhat', 'tab' => 'Nguồn phim'
        ]);
        CRUD::addField([
            'name' => 'exclude_categories',
            'label' => 'Loại trừ thể loại',
            'type' => 'select2_tags',
            'hint' => 'Nhập thể loại rồi ấn Enter',
            'tab' => 'Nguồn phim'
        ]);
        CRUD::addField([
            'name' => 'exclude_regions',
            'label' => 'Loại trừ quốc gia',
            'type' => 'select2_tags',
            'hint' => 'Nhập quốc gia rồi ấn Enter',
            'tab' => 'Nguồn phim'
        ]);

        CRUD::addField([
            'name' => 'from_page',
            'label' => 'Từ trang',
            'type' => 'number',
            'default' => 1,
            'tab' => 'Nguồn phim'
        ]);
        CRUD::addField(['name' => 'to_page', 'label' => 'Đến trang', 'type' => 'number', 'default' => 1, 'tab' => 'Nguồn phim']);

        CRUD::addField(['name' => 'fields', 'type' => 'view', 'view' => 'ophim::base.fields.update_fields_option', 'tab' => 'Tùy chọn cập nhật']);

        CRUD::addField(['name' => 'at_month', 'label' => 'Tháng', 'type' => 'text', 'default' => '*', 'tab' => 'Thời gian chạy']);
        CRUD::addField(['name' => 'at_week', 'label' => 'Tuần', 'type' => 'text', 'default' => '*', 'tab' => 'Thời gian chạy']);
        CRUD::addField(['name' => 'at_day', 'label' => 'Ngày', 'type' => 'text', 'default' => '*', 'tab' => 'Thời gian chạy']);
        CRUD::addField(['name' => 'at_hour', 'label' => 'Giờ', 'type' => 'text', 'default' => '*', 'tab' => 'Thời gian chạy']);
        CRUD::addField(['name' => 'at_minute', 'label' => 'Phút', 'type' => 'text', 'default' => '0',  'tab' => 'Thời gian chạy']);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->authorize('update', $this->crud->entry);

        $this->setupCreateOperation();
    }

    protected function setupDeleteOperation()
    {
        $this->authorize('delete', $this->crud->entry);
    }
}
