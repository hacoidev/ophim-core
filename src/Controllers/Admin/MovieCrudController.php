<?php

namespace Ophim\Core\Controllers\Admin;

use Ophim\Core\Requests\MovieRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Settings\app\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Ophim\Core\Models\Actor;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Str;
use Ophim\Core\Database\Seeders\MenusTableSeeder;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\Director;
use Ophim\Core\Models\Episode;
use Ophim\Core\Models\Movie;
use Ophim\Core\Models\Region;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

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
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number','tab'=>'Thông tin phim']);
         */

        CRUD::addColumn(['name' => 'name', 'label' => 'Tên', 'type' => 'text',]);
        CRUD::addColumn([
            'name' => 'thumb_url', 'label' => 'Ảnh thumb', 'type' => 'image',
            'height' => '100px',
            'width'  => 'auto',
        ]);
        CRUD::addColumn(['name' => 'status', 'label' => 'Tình trạng', 'type' => 'text',]);
        CRUD::addColumn(['name' => 'categories', 'label' => 'Thể loại', 'type' => 'relationship',]);
        CRUD::addColumn(['name' => 'regions', 'label' => 'Khu vực', 'type' => 'relationship',]);
        CRUD::addColumn(['name' => 'publish_year', 'label' => 'Năm', 'type' => 'text',]);
        CRUD::addColumn(['name' => 'user_name', 'label' => 'Cập nhật bởi', 'type' => 'text',]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
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
        CRUD::addField(['name' => 'notify', 'label' => 'Thông báo / ghi chú', 'type' => 'summernote', 'tab' => 'Thông tin phim']);

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
        CRUD::addField(['name' => 'directors', 'label' => 'Đạo diễn', 'type' => 'select2_tags', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'actors', 'label' => 'Diễn viên',  'type' => 'select2_tags', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'tags', 'label' => 'Tags',  'type' => 'select2_tags', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'is_shown_in_theater', 'label' => 'Phim chiếu rạp', 'type' => 'boolean', 'tab' => 'Phân loại']);
        CRUD::addField(['name' => 'is_copyright', 'label' => 'Có bản quyền phim', 'type' => 'boolean', 'tab' => 'Phân loại']);

        CRUD::addField(['name' => 'is_sensitive_content', 'label' => 'Cảnh báo nội dung người lớn', 'type' => 'boolean', 'tab' => 'Thông tin phim']);
        CRUD::addField(['name' => 'is_recommended', 'label' => 'Đề cử', 'type' => 'boolean', 'tab' => 'Thông tin phim']);

        CRUD::addField([
            'name' => 'episodes',
            'type' => 'view',
            'view' => 'ophim::movies.inc.episode',
            'tab' => 'Danh sách tập phim'
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
        $this->setupCreateOperation();
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

        $request['actors'] = $actor_ids;
        $request['directors'] = $director_ids;
        $request['tags'] = $tag_ids;

        return [$actor_ids, $director_ids, $tag_ids];
    }

    protected function setupCrawlRoutes($segment, $routeName, $controller)
    {
        Route::any($segment . '/crawl/fetch', [
            'as'        => $routeName . '.crawl',
            'uses'      => $controller . '@fetchMovieList',
            'operation' => 'crawl',
        ]);

        Route::get($segment . '/crawl', [
            'as'        => $routeName . '.crawl',
            'uses'      => $controller . '@showCrawlPage',
            'operation' => 'crawl',
        ]);

        Route::post($segment . '/crawl', [
            'as'        => $routeName . '.crawl',
            'uses'      => $controller . '@crawl',
            'operation' => 'crawl',
        ]);
    }

    public function fetchMovieList(Request $request)
    {
        $data = collect();

        $request['link'] = preg_split('/[\n\r]+/', $request['link']);

        foreach ($request['link'] as $link) {
            if (preg_match('/(.*?)(\/phim\/)(.*?)/', $link)) {
                $response = json_decode(file_get_contents($link), true);
                $data->push(collect($response['movie'])->only('name', 'slug')->toArray());
            } else {
                for ($i = $request['from']; $i <= $request['to']; $i++) {
                    $response = json_decode(Http::timeout(3)->get($link, [
                        'page' => $i
                    ]), true);
                    $data->push(...$response['items']);
                }
            }
        }

        return $data;
    }

    public function showCrawlPage(Request $request)
    {
        $this->crud->hasAccessOrFail('create');
        $this->crud->setOperation('Crawl');

        return view('crawl');
    }

    public function crawl(Request $request)
    {
        $pattern = sprintf('%s/phim/{slug}', Setting::get('ophim_api_url', 'https://ophim1.com'));

        try {
            $res = json_decode(file_get_contents(str_replace('{slug}', $request['slug'], $pattern)), true);
            $info = $res['movie'];
            $episodes = $res['episodes'];
            $movie = Movie::firstOrCreate([
                'name' => $info['name'],
                'origin_name' => $info['origin_name']
            ], [
                'publish_year' => $info['year'],
                'content' => $info['content'],
                'type' =>  $this->getMovieType($info, $episodes),
                'status' => $info['status'],
                'thumb_url' => $this->getImage($request['slug'], $info['thumb_url']),
                'poster_url' => $this->getImage($request['slug'], $info['poster_url']),
                'is_copyright' => $info['is_copyright'] != 'off',
                'trailer_url' => $info['trailer_url'] ?? "",
                'quality' => $info['quality'],
                'language' => $info['lang'],
                'is_recommended' => rand(0, 1)
            ]);

            $actors = [];
            $directors = [];
            $categories = [];
            $regions = [];
            foreach ($info['actor'] as $actor) {
                $actors[] = Actor::firstOrCreate(['name' => $actor])->id;
            }
            foreach ($info['director'] as $director) {
                $directors[] = Director::firstOrCreate(['name' => $director])->id;
            }
            foreach ($info['category'] as $category) {
                $categories[] = Category::firstOrCreate(['name' => $category['name']])->id;
            }
            foreach ($info['country'] as $region) {
                $regions[] = Region::firstOrCreate(['name' => $region['name']])->id;
            }

            $movie->actors()->sync($actors);
            $movie->directors()->sync($directors);
            $movie->categories()->sync($categories);
            $movie->regions()->sync($regions);

            foreach ($episodes as $server) {
                foreach ($server['server_data'] as $episode) {
                    if ($episode['link_m3u8']) {
                        Episode::firstOrCreate([
                            'name' => $episode['name'],
                            'movie_id' => $movie->id,
                            'server' => $server['server_name'],
                            'type' => 'm3u8'
                        ], [
                            'link' => $episode['link_m3u8'],
                            'slug' => 'tap-' . $episode['name']
                        ]);
                    }
                    if ($episode['link_embed']) {
                        Episode::firstOrCreate([
                            'name' => $episode['name'],
                            'movie_id' => $movie->id,
                            'server' => $server['server_name'],
                            'type' => 'embed',
                        ], [
                            'link' => $episode['link_embed'],
                            'slug' => 'tap-' . $episode['name']
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        (new MenusTableSeeder)->run();

        return response()->json(['message' => 'OK']);
    }

    protected function getMovieType($info, $episodes)
    {
        return $info['type'] == 'series' ? 'series'
            : ($info['type'] == 'single' ? 'single'
                : (count(reset($episodes)['server_data'] ?? []) > 1 ? 'series' : 'single'));
    }

    protected function getImage($slug, string $url): string
    {
        if (empty($url)) return '';
        $contents = file_get_contents($url);
        $filename = substr($url, strrpos($url, '/') + 1);
        $path = "{$slug}/{$filename}";
        Storage::disk('public')->put($path, $contents);
        return Storage::url($path);
    }
}
