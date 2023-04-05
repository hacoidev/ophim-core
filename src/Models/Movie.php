<?php

namespace Ophim\Core\Models;

use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\Settings\app\Models\Setting;
use Ophim\Core\Contracts\TaxonomyInterface;
use Hacoidev\CachingModel\Contracts\Cacheable;
use Hacoidev\CachingModel\HasCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Ophim\Core\Contracts\SeoInterface;
use Ophim\Core\Traits\ActorLog;
use Ophim\Core\Traits\HasFactory;
use Ophim\Core\Traits\HasTitle;
use Ophim\Core\Traits\Sluggable;

class Movie extends Model implements TaxonomyInterface, Cacheable, SeoInterface
{
    use CrudTrait;
    use ActorLog;
    use Sluggable;
    use HasFactory;
    use HasCache;
    use HasTitle;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'movies';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

        static::updating(function ($instance) {
            $instance->timestamps = request('timestamps') ?: false;
        });
    }

    public static function primaryCacheKey(): string
    {
        $site_routes = setting('site_routes_movie', '/phim/{movie}');
        if (strpos($site_routes, '{movie}')) return 'slug';
        if (strpos($site_routes, '{id}')) return 'id';
        return 'slug';
    }

    public function getUrl()
    {
        $params = [];
        $site_routes = setting('site_routes_movie', '/phim/{movie}');
        if (strpos($site_routes, '{movie}')) $params['movie'] = $this->slug;
        if (strpos($site_routes, '{id}')) $params['id'] = $this->id;
        return route('movies.show', $params);
    }

    public function getThumbUrl()
    {
        if (setting('site_image_proxy_enable', false)) {
            $image_url = filter_var($this->thumb_url, FILTER_VALIDATE_URL) ? $this->thumb_url : url('/') . $this->thumb_url;
            return str_replace('{image_url}', urlencode($image_url), setting('site_image_proxy_url', ''));
        }
        return $this->thumb_url;
    }

    public function getPosterUrl()
    {
        if ($this->poster_url) {
            if (setting('site_image_proxy_enable', false)) {
                $image_url = filter_var($this->poster_url, FILTER_VALIDATE_URL) ? $this->poster_url : url('/') . $this->poster_url;
                return str_replace('{image_url}', urlencode($image_url), setting('site_image_proxy_url', ''));
            }
            return $this->poster_url;
        }
        return $this->getThumbUrl();
    }

    public function getRatingStar()
    {
        return number_format($this->rating_star > 0 ? $this->rating_star : 8, 1);
    }

    public function getRatingCount()
    {
        return $this->rating_count >= 1 ? $this->rating_count : 1;
    }

    public function generateSeoTags()
    {
        $movie_thumb_url = filter_var($this->thumb_url, FILTER_VALIDATE_URL) ? $this->thumb_url : request()->root() . $this->thumb_url;
        $movie_poster_url = filter_var($this->poster_url, FILTER_VALIDATE_URL) ? $this->poster_url : request()->root() . $this->poster_url;
        $seo_des = Str::limit(strip_tags($this->content), 150, '...');
        $getTitle = $this->getTitle();
        $getUrl = $this->getUrl();
        $site_meta_siteName = setting('site_meta_siteName');

        SEOMeta::setTitle($getTitle, false)
            ->setDescription($seo_des)
            ->addKeyword($this->tags()->pluck('name')->toArray())
            ->addMeta('article:published_time', $this->updated_at->toW3CString(), 'property')
            ->addMeta('article:section', $this->categories->pluck('name')->join(","), 'property')
            ->addMeta('article:tag', $this->tags->pluck('name')->join(","), 'property')
            ->setCanonical($getUrl)
            ->setPrev(url('/'))
            ->setPrev(url('/'));

        if ($this->type === 'single') {
            OpenGraph::setType('video.movie')
                ->setTitle($getTitle, false)
                ->setDescription($seo_des)
                ->setSiteName($site_meta_siteName)
                ->addProperty('locale', 'vi-VN')
                ->addProperty('updated_time', $this->updated_at)
                ->addProperty('url', $getUrl)
                ->addImages([$movie_thumb_url,$movie_poster_url])
                ->setVideoMovie([
                    'actor' => $this->actors->pluck('name')->join(","),
                    'director' => $this->directors->pluck('name')->join(","),
                    'duration' => $this->episode_time,
                    'release_date' => $this->created_at,
                    'tag' => $this->tags->pluck('name')->join(", ")
                ]);
        } else {
            OpenGraph::setType('video.tv_show')
                ->setTitle($getTitle, false)
                ->setDescription($seo_des)
                ->setSiteName($site_meta_siteName)
                ->addProperty('locale', 'vi-VN')
                ->addProperty('updated_time', $this->updated_at)
                ->addProperty('url', $getUrl)
                ->addImages([$movie_thumb_url,$movie_poster_url])
                ->setVideoTVShow([
                    'actor' => $this->actors->pluck('name')->join(","),
                    'director' => $this->directors->pluck('name')->join(","),
                    'duration' => $this->episode_time,
                    'release_date' => $this->created_at,
                    'tag' => $this->tags->pluck('name')->join(", ")
                ]);
        }

        TwitterCard::setSite($site_meta_siteName)
            ->setTitle($getTitle, false)
            ->setType('summary')
            ->setImage($movie_thumb_url)
            ->setDescription($seo_des)
            ->setUrl($getUrl);

        JsonLdMulti::newJsonLd()
            ->setSite($site_meta_siteName)
            ->addValue('dateCreated', $this->created_at)
            ->addValue('dateModified', $this->updated_at)
            ->addValue('datePublished', $this->created_at)
            ->setTitle($getTitle, false)
            ->setType('Movie')
            ->setDescription($seo_des)
            ->setImages([$movie_thumb_url, $movie_poster_url])
            ->addValue('aggregateRating', [
                '@type' => 'AggregateRating',
                'bestRating' => "10",
                'worstRating' => "1",
                'ratingValue' => $this->getRatingStar(),
                'reviewCount' => $this->getRatingCount()
            ])
            ->addValue('director', count($this->directors) ? $this->directors->map(function ($director) {
                return ['@type' => 'Person', 'name' => $director->name];
            }) : "")
            ->addValue('actor', count($this->actors) ? $this->actors->map(function ($actor) {
                return ['@type' => 'Person', 'name' => $actor->name];
            }) : "")
            ->setUrl($getUrl);

        $breadcrumb = [];
        array_push($breadcrumb, [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => url('/')
        ]);
        foreach ($this->regions as $item) {
            array_push($breadcrumb, [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $item->name,
                'item' => $item->getUrl(),
            ]);
        }
        foreach ($this->categories as $item) {
            array_push($breadcrumb, [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $item->name,
                'item' => $item->getUrl(),
            ]);
        }
        array_push($breadcrumb, [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $this->name
        ]);

        JsonLdMulti::newJsonLd()
            ->setType('BreadcrumbList')
            ->addValue('name', '')
            ->addValue('description', '')
            ->addValue('itemListElement', $breadcrumb);
    }

    public function openView($crud = false)
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="' . $this->getUrl() . '" data-toggle="tooltip" title="View link"><i class="la la-link"></i> View</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function directors()
    {
        return $this->belongsToMany(Director::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function studios()
    {
        return $this->belongsToMany(Studio::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getStatus()
    {
        $statuses = [
            'trailer' => __('Sắp chiếu'),
            'ongoing' => __('Đang chiếu'),
            'completed' => __('Hoàn thành')
        ];
        return $statuses[$this->status];
    }

    protected function titlePattern(): string
    {
        return Setting::get('site_movie_title', '');
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
