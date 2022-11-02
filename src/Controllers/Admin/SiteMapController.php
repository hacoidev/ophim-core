<?php

namespace Ophim\Core\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Settings\app\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL as LARURL;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Ophim\Core\Models\Actor;
use Ophim\Core\Models\Catalog;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\Director;
use Ophim\Core\Models\Movie;
use Ophim\Core\Models\Region;
use Ophim\Core\Models\Studio;
use Ophim\Core\Models\Tag;
use Prologue\Alerts\Facades\Alert;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SiteMapController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sitemap');
        CRUD::setEntityNameStrings('site map', 'site map');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::addField(['name' => 'sitemap', 'type' => 'custom_html', 'value' => 'Sitemap sẽ được lưu tại đường dẫn: <i>' . url('/sitemap.xml') . '</i>']);
        $this->crud->addSaveAction([
            'name' => 'save_and_new',
            'redirect' => function ($crud, $request, $itemId) {
                return $crud->route;
            },
            'button_text' => 'Tạo sitemap',
        ]);

        $this->crud->setOperationSetting('showSaveActionChange', false);
    }

    public function render_styles()
    {
        $xml = view('ophim::sitemap/styles', [
            'title' => Setting::get('site_homepage_title'),
            'domain' => LARURL::to('/')
        ])->render();

        file_put_contents(public_path('main-sitemap.xsl'), $xml);
        return;
    }

    public function add_styles($file_name)
    {
        $path = public_path($file_name);
        if(file_exists($path)) {
            $content = file_get_contents($path);
            $content = str_replace('?'.'>', '?'.'>'.'<'.'?'.'xml-stylesheet type="text/xsl" href="'. LARURL::to('/') .'/main-sitemap.xsl"?'.'>', $content);
            file_put_contents($path, $content);
        }
    }

    public function store(Request $request)
    {
        $this->render_styles();
        if (!File::isDirectory('sitemap')) File::makeDirectory('sitemap', 0777, true, true);

        $sitemap_index = SitemapIndex::create();

        $sitemap_page = Sitemap::create();
        $sitemap_page->add(Url::create('/')
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
            ->setPriority(1));
        Catalog::chunkById(100, function ($catalogs) use ($sitemap_page) {
            foreach ($catalogs as $catalog) {
                $sitemap_page->add(
                    Url::create($catalog->getUrl())
                        ->setLastModificationDate(now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.9)
                );
            }
        });
        $sitemap_page->writeToFile(public_path('sitemap/page-sitemap.xml'));
        $this->add_styles('sitemap/page-sitemap.xml');
        $sitemap_index->add('sitemap/page-sitemap.xml');

        $sitemap_categories = Sitemap::create();
        Category::chunkById(100, function ($categoires) use ($sitemap_categories) {
            foreach ($categoires as $category) {
                $sitemap_categories->add(
                    Url::create($category->getUrl())
                        ->setLastModificationDate(now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.8)
                );
            }
        });
        $sitemap_categories->writeToFile(public_path('sitemap/categories-sitemap.xml'));
        $this->add_styles('sitemap/categories-sitemap.xml');
        $sitemap_index->add('sitemap/categories-sitemap.xml');

        $sitemap_regions = Sitemap::create();
        Region::chunkById(100, function ($regions) use ($sitemap_regions) {
            foreach ($regions as $region) {
                $sitemap_regions->add(
                    Url::create($region->getUrl())
                        ->setLastModificationDate(now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.8)
                );
            }
        });
        $sitemap_regions->writeToFile(public_path('sitemap/regions-sitemap.xml'));
        $this->add_styles('sitemap/regions-sitemap.xml');
        $sitemap_index->add('sitemap/regions-sitemap.xml');

        $chunk = 0;
        Movie::chunkById(200, function ($movies) use ($sitemap_index, &$chunk) {
            $chunk++;
            $sitemap_movies = null;
            $sitemap_movies = Sitemap::create();
            foreach ($movies as $movie) {
                $sitemap_movies->add(
                    Url::create($movie->getUrl())
                        ->setLastModificationDate($movie->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.7)
                );
            }
            $sitemap_movies->writeToFile(public_path("sitemap/movies-sitemap{$chunk}.xml"));
            $this->add_styles("sitemap/movies-sitemap{$chunk}.xml");
            $sitemap_index->add("sitemap/movies-sitemap{$chunk}.xml");
        });

        $sitemap_index->writeToFile(public_path('sitemap.xml'));
        $this->add_styles("sitemap.xml");

        Alert::success("Đã tạo thành công sitemap tại thư mục public")->flash();

        return back();
    }
}
