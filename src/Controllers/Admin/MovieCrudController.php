<?php

namespace Ophim\Core\Controllers\Admin;

use Ophim\Core\Requests\MovieRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ophim\Core\Models\Actor;
use Ophim\Core\Models\Director;
use Ophim\Core\Models\Movie;
use Ophim\Core\Models\Region;
use Ophim\Core\Models\Studio;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\Tag;

/**
 * Class MovieCrudController
 * @package Ophim\Core\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MovieCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as backpackStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as backpackUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation {
        destroy as traitDestroy;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \Ophim\Core\Traits\Operations\BulkDeleteOperation {
        bulkDelete as traitBulkDelete;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Ophim\Core\Models\Movie::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/movie');
        CRUD::setEntityNameStrings('movie', 'movies');
        CRUD::setCreateView('ophim::movies.create',);
        CRUD::setUpdateView('ophim::movies.edit',);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->authorize('browse', Movie::class);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number','tab'=>'Thông tin phim']);
         */

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'select2',
            'label' => 'Tình trạng'
        ], function () {
            return [
                'trailer' => 'Sắp chiếu',
                'ongoing' => 'Đang chiếu',
                'completed' => 'Hoàn thành'
            ];
        }, function ($val) {
            $this->crud->addClause('where', 'status', $val);
        });

        $this->crud->addFilter([
            'name'  => 'type',
            'type'  => 'select2',
            'label' => 'Định dạng'
        ], function () {
            return [
                'single' => 'Phim lẻ',
                'series' => 'Phim bộ'
            ];
        }, function ($val) {
            $this->crud->addClause('where', 'type', $val);
        });

        $this->crud->addFilter([
            'name'  => 'category_id',
            'type'  => 'select2',
            'label' => 'Thể loại'
        ], function () {
            return Category::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->query = $this->crud->query->whereHas('categories', function ($query) use ($value) {
                $query->where('id', $value);
            });
        });

        $this->crud->addFilter([
            'name'  => 'region_id',
            'type'  => 'select2',
            'label' => 'Quốc gia'
        ], function () {
            return Region::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->query = $this->crud->query->whereHas('regions', function ($query) use ($value) {
                $query->where('id', $value);
            });
        });

        $this->crud->addFilter([
            'name'  => 'other',
            'type'  => 'select2',
            'label' => 'Thông tin'
        ], function () {
            return [
                'thumb_url-' => 'Thiếu ảnh thumb',
                'poster_url-' => 'Thiếu ảnh poster',
                'trailer_url-' => 'Thiếu trailer',
                'language-vietsub' => 'Vietsub',
                'language-thuyết minh' => 'Thuyết minh',
                'language-lồng tiếng' => 'Lồng tiếng',
            ];
        }, function ($values) {
            $value = explode("-", $values);
            $field = $value[0];
            $val = $value[1];
            if($field === 'language') {
                $this->crud->query->where($field, 'like', '%' . $val . '%');
            } else {
                $this->crud->query->where($field, '')->orWhere($field, NULL)->orWhere($field, 'like', '%img.ophim%')->orWhere($field, 'like', '%img.hiephanhthienha%');
            }
        });

        $this->crud->addFilter(
            [
                'type'  => 'simple',
                'name'  => 'is_recommended',
                'label' => 'Đề cử'
            ],
            false,
            function () {
                $this->crud->addClause('where', 'is_recommended', true);
            }
        );

        $this->crud->addFilter(
            [
                'type'  => 'simple',
                'name'  => 'is_shown_in_theater',
                'label' => 'Chiếu rạp'
            ],
            false,
            function () {
                $this->crud->addClause('where', 'is_shown_in_theater', true);
            }
        );

        CRUD::addButtonFromModelFunction('line', 'open_view', 'openView', 'beginning');

        CRUD::addColumn([
            'name' => 'name',
            'origin_name' => 'origin_name',
            'publish_year' => 'publish_year',
            'status' => 'status',
            'movie_type' => 'type',
            'episode_current' => 'episode_current',
            'label' => 'Thông tin',
            'type' => 'view',
            'view' => 'ophim::movies.columns.column_movie_info',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->whereRaw("MATCH(name, origin_name) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
            }
        ]);

        CRUD::addColumn([
            'name' => 'thumb_url', 'label' => 'Ảnh thumb', 'type' => 'image',
            'height' => '100px',
            'width'  => '68px',
        ]);
        CRUD::addColumn(['name' => 'categories', 'label' => 'Thể loại', 'type' => 'relationship',]);
        CRUD::addColumn(['name' => 'regions', 'label' => 'Khu vực', 'type' => 'relationship',]);
        CRUD::addColumn(['name' => 'updated_at', 'label' => 'Cập nhật lúc', 'type' => 'datetime', 'format' => 'DD/MM/YYYY HH:mm:ss']);
        // CRUD::addColumn(['name' => 'user_name', 'label' => 'Cập nhật bởi', 'type' => 'text',]);
        CRUD::addColumn(['name' => 'view_total', 'label' => 'Lượt xem', 'type' => 'number',]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->authorize('create', Movie::class);

        CRUD::setValidation(MovieRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */

        CRUD::addField(['name' => 'name', 'label' => 'Tên phim', 'type' => 'text', 'wrapperAttributes' => [
            'class' => 'form-group col-md-6'
        ], 'attributes' => ['placeholder' => 'Tên'], 'tab' => 'Thông tin phim']);
        CRUD::addField(['name' => 'origin_name', 'label' => 'Tên gốc', 'type' => 'text', 'wrapperAttributes' => [
            'class' => 'form-group col-md-6'
        ], 'tab' => 'Thông tin phim']);
        CRUD::addField(['name' => 'slug', 'label' => 'Đường dẫn tĩnh', 'type' => 'text', 'tab' => 'Thông tin phim']);
        CRUD::addField([
            'name' => 'thumb_url', 'label' => 'Ảnh Thumb', 'type' => 'ckfinder', 'preview' => ['width' => 'auto', 'height' => '340px'], 'tab' => 'Thông tin phim'
        ]);
        CRUD::addField(['name' => 'poster_url', 'label' => 'Ảnh Poster', 'type' => 'ckfinder', 'preview' => ['width' => 'auto', 'height' => '340px'], 'tab' => 'Thông tin phim']);

        CRUD::addField(['name' => 'content', 'label' => 'Nội dung', 'type' => 'summernote', 'tab' => 'Thông tin phim']);
        CRUD::addField(['name' => 'notify', 'label' => 'Thông báo / ghi chú', 'type' => 'text', 'attributes' => ['placeholder' => 'Tuần này hoãn chiếu'], 'tab' => 'Thông tin phim']);

        CRUD::addField(['name' => 'showtimes', 'label' => 'Lịch chiếu phim', 'type' => 'text', 'attributes' => ['placeholder' => '21h tối hàng ngày'], 'tab' => 'Thông tin phim']);
        CRUD::addField(['name' => 'trailer_url', 'label' => 'Trailer Youtube URL', 'type' => 'text', 'tab' => 'Thông tin phim']);

        CRUD::addField(['name' => 'episode_time', 'label' => 'Thời lượng tập phim', 'type' => 'text', 'wrapperAttributes' => [
            'class' => 'form-group col-md-4'
        ], 'attributes' => ['placeholder' => '45 phút'], 'tab' => 'Thông tin phim']);
        CRUD::addField(['name' => 'episode_current', 'label' => 'Tập phim hiện tại', 'type' => 'text', 'wrapperAttributes' => [
            'class' => 'form-group col-md-4'
        ], 'attributes' => ['placeholder' => '5'], 'tab' => 'Thông tin phim']);

        CRUD::addField(['name' => 'episode_total', 'label' => 'Tổng số tập phim', 'type' => 'text', 'wrapperAttributes' => [
            'class' => 'form-group col-md-4'
        ], 'attributes' => ['placeholder' => '12'], 'tab' => 'Thông tin phim']);

        CRUD::addField(['name' => 'language', 'label' => 'Ngôn ngữ', 'type' => 'text', 'wrapperAttributes' => [
            'class' => 'form-group col-md-4'
        ], 'attributes' => ['placeholder' => 'Tiếng Việt'], 'tab' => 'Thông tin phim']);

        CRUD::addField(['name' => 'quality', 'label' => 'Chất lượng', 'type' => 'text', 'wrapperAttributes' => [
            'class' => 'form-group col-md-4'
        ], 'tab' => 'Thông tin phim']);

        CRUD::addField(['name' => 'publish_year', 'label' => 'Năm xuất bản', 'type' => 'text', 'wrapperAttributes' => [
            'class' => 'form-group col-md-4'
        ], 'tab' => 'Thông tin phim']);

        CRUD::addField(['name' => 'type', 'label' => 'Định dạng', 'type' => 'radio', 'options' => ['single' => 'Phim lẻ', 'series' => 'Phim bộ'], 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'status', 'label' => 'Tình trạng', 'type' => 'radio', 'options' => ['trailer' => 'Sắp chiếu', 'ongoing' => 'Đang chiếu', 'completed' => 'Hoàn thành'], 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'categories', 'label' => 'Thể loại', 'type' => 'checklist', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'regions', 'label' => 'Khu vực', 'type' => 'checklist', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'directors', 'label' => 'Đạo diễn', 'type' => 'select2_relationship_tags', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'actors', 'label' => 'Diễn viên',  'type' => 'select2_relationship_tags', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'tags', 'label' => 'Tags',  'type' => 'select2_relationship_tags', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'studios', 'label' => 'Studios',  'type' => 'select2_relationship_tags', 'tab' => 'Phân loại']);

        CRUD::addField([
            'name' => 'episodes',
            'type' => 'view',
            'view' => 'ophim::movies.inc.episode',
            'tab' => 'Danh sách tập phim'
        ],);

        CRUD::addField(['name' => 'update_handler', 'label' => 'Trình cập nhật', 'type' => 'select_from_array', 'options' => collect(config('ophim.updaters', []))->pluck('name', 'handler')->toArray(), 'tab' => 'Cập nhật']);
        CRUD::addField(['name' => 'update_identity', 'label' => 'ID cập nhật', 'type' => 'text', 'tab' => 'Cập nhật']);

        CRUD::addField(['name' => 'is_shown_in_theater', 'label' => 'Phim chiếu rạp', 'type' => 'boolean', 'tab' => 'Khác']);
        CRUD::addField(['name' => 'is_copyright', 'label' => 'Có bản quyền phim', 'type' => 'boolean', 'tab' => 'Khác']);
        CRUD::addField(['name' => 'is_sensitive_content', 'label' => 'Cảnh báo nội dung người lớn', 'type' => 'boolean', 'tab' => 'Khác']);
        CRUD::addField(['name' => 'is_recommended', 'label' => 'Đề cử', 'type' => 'boolean', 'tab' => 'Khác']);
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
        CRUD::addField(['name' => 'timestamps', 'label' => 'Cập nhật thời gian', 'type' => 'checkbox', 'tab' => 'Cập nhật']);
    }

    public function store(Request $request)
    {
        $this->getTaxonamies($request);

        return $this->backpackStore();
    }

    public function update(Request $request)
    {
        $this->getTaxonamies($request);

        return $this->backpackUpdate();
    }

    protected function getTaxonamies(Request $request)
    {
        $actors = request('actors', []);
        $directors = request('directors', []);
        $tags = request('tags', []);
        $studios = request('studios', []);

        $actor_ids = [];
        foreach ($actors as $actor) {
            $actor_ids[] = Actor::firstOrCreate([
                'name_md5' => md5($actor)
            ], [
                'name' => $actor
            ])->id;
        }

        $director_ids = [];
        foreach ($directors as $director) {
            $director_ids[] = Director::firstOrCreate([
                'name_md5' => md5($director)
            ], [
                'name' => $director
            ])->id;
        }

        $tag_ids = [];
        foreach ($tags as $tag) {
            $tag_ids[] = Tag::firstOrCreate([
                'name_md5' => md5($tag)
            ], [
                'name' => $tag
            ])->id;
        }

        $studio_ids = [];
        foreach ($studios as $studio) {
            $studio_ids[] = Studio::firstOrCreate([
                'name_md5' => md5($studio)
            ], [
                'name' => $studio
            ])->id;
        }

        $request['actors'] = $actor_ids;
        $request['directors'] = $director_ids;
        $request['tags'] = $tag_ids;
        $request['studios'] = $studio_ids;
    }

    // protected function setupDeleteOperation()
    // {
    //     $this->authorize('delete', $this->crud->getEntryWithLocale($this->crud->getCurrentEntryId()));
    // }

    public function deleteImage($movie)
    {
        // Delete images
        if ($movie->thumb_url && !filter_var($movie->thumb_url, FILTER_VALIDATE_URL) && file_exists(public_path($movie->thumb_url))) {
            unlink(public_path($movie->thumb_url));
        }
        if ($movie->poster_url && !filter_var($movie->poster_url, FILTER_VALIDATE_URL) && file_exists(public_path($movie->poster_url))) {
            unlink(public_path($movie->poster_url));
        }
        return true;
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        $movie = Movie::find($id);

        $this->deleteImage($movie);

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        $res = $this->crud->delete($id);
        if ($res) {
        }
        return $res;
    }

    public function bulkDelete()
    {
        $this->crud->hasAccessOrFail('bulkDelete');
        $entries = request()->input('entries', []);
        $deletedEntries = [];

        foreach ($entries as $key => $id) {
            if ($entry = $this->crud->model->find($id)) {
                $this->deleteImage($entry);
                $deletedEntries[] = $entry->delete();
            }
        }

        return $deletedEntries;
    }
}
