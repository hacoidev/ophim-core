<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\Settings\app\Models\Setting;
use Ophim\Core\Contracts\HasUrlInterface;
use Hacoidev\CachingModel\Contracts\Cacheable;
use Hacoidev\CachingModel\HasCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Ophim\Core\Contracts\SeoInterface;
use Ophim\Core\Traits\HasFactory;
use Ophim\Core\Traits\HasTitle;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class Episode extends Model implements Cacheable, HasUrlInterface, SeoInterface
{
    use CrudTrait;
    use HasFactory;
    use HasCache;
    use HasTitle;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'episodes';
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

    public function getUrl()
    {
        $movie = Cache::remember("cache_movie_by_id:" . $this->movie_id, setting('site_cache_ttl', 5 * 60), function () {
            return $this->movie;
        });

        $params = [];
        $site_routes_movie = setting('site_routes_episode', '/phim/{movie}/{episode}-{id}');
        if (strpos($site_routes_movie, '{movie}')) $params['movie'] = $movie->slug;
        if (strpos($site_routes_movie, '{movie_id}')) $params['movie_id'] = $movie->id;
        if (strpos($site_routes_movie, '{episode}')) $params['episode'] = $this->slug;
        if (strpos($site_routes_movie, '{id}')) $params['id'] = $this->id;

        return route('episodes.show', $params);
    }

    public function openEpisode($crud = false)
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="' . $this->getUrl() . '" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i> Open it</a>';
    }

    protected function titlePattern(): string
    {
        return Setting::get('site_episode_watch_title', '');
    }

    public function generateSeoTags()
    {
        $movie_thumb_url = filter_var($this->movie->thumb_url, FILTER_VALIDATE_URL) ? $this->movie->thumb_url : request()->root() . $this->movie->thumb_url;
        $movie_poster_url = filter_var($this->movie->poster_url, FILTER_VALIDATE_URL) ? $this->movie->poster_url : request()->root() . $this->movie->poster_url;
        $movie_description = Str::limit(strip_tags($this->movie->content), 150, '...');
        $episode_getUrl = $this->getUrl();
        $getTitle = $this->getTitle();
        $site_meta_siteName = setting('site_meta_siteName');

        SEOMeta::setTitle($getTitle, false)
            ->setDescription($movie_description)
            ->addKeyword($this->movie->tags()->pluck('name')->toArray())
            ->addMeta('article:published_time', $this->updated_at->toW3CString(), 'property')
            ->addMeta('article:section', $this->movie->categories->pluck('name')->join(","), 'property')
            ->addMeta('article:tag', $this->movie->tags->pluck('name')->join(","), 'property')
            ->setCanonical($episode_getUrl)
            ->setPrev(request()->root())
            ->setPrev(request()->root());

        OpenGraph::setType('video.episode')
            ->setSiteName($site_meta_siteName)
            ->setTitle($getTitle, false)
            ->addProperty('locale', 'vi-VN')
            ->addProperty('url', $episode_getUrl)
            ->addProperty('updated_time', $this->movie->updated_at)
            ->setDescription($movie_description)
            ->addImages([$movie_thumb_url,$movie_poster_url])
            ->setVideoEpisode([
                'actor' => $this->movie->actors->pluck('name')->join(","),
                'director' => $this->movie->directors->pluck('name')->join(","),
                'duration' => $this->movie->episode_time,
                'release_date' => $this->created_at,
                'tag' => $this->movie->tags->pluck('name')->join(", "),
                'series' => 'video.tv_show'
            ]);

        TwitterCard::setSite($site_meta_siteName)
            ->setTitle($getTitle, false)
            ->setType('summary')
            ->setImage($movie_thumb_url)
            ->setDescription($movie_description)
            ->setUrl($episode_getUrl);

        JsonLdMulti::newJsonLd()
            ->setSite($site_meta_siteName)
            ->addValue('dateCreated', $this->created_at)
            ->addValue('dateModified', $this->updated_at)
            ->addValue('datePublished', $this->created_at)
            ->setTitle($getTitle, false)
            ->setType('Movie')
            ->setDescription($movie_description)
            ->setImages([$movie_thumb_url,$movie_poster_url])
            ->addValue('aggregateRating', [
                '@type' => 'AggregateRating',
                'bestRating' => "10",
                'worstRating' => "1",
                'ratingValue' => $this->movie->getRatingStar(),
                'reviewCount' => $this->movie->getRatingCount()
            ])
            ->addValue('director', count($this->movie->directors) ? $this->movie->directors->map(function ($director) {
                return ['@type'=> 'Person', 'name' => $director->name];
            }) : "")
            ->addValue('actor', count($this->movie->actors) ? $this->movie->actors->map(function ($actor) {
                return ['@type'=> 'Person', 'name' => $actor->name];
            }) : "")
            ->setUrl($episode_getUrl);
        // ->addValue($key, $value);

        $breadcrumb = [];
        array_push($breadcrumb, [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => url('/')
        ]);
        foreach ($this->movie->regions as $item) {
            array_push($breadcrumb, [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $item->name,
                'item' => $item->getUrl(),
            ]);
        }
        foreach ($this->movie->categories as $item) {
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
            'name' => $this->movie->name,
            'item' => $this->movie->getUrl()
        ]);
        array_push($breadcrumb, [
            '@type' => 'ListItem',
            'position' => 4,
            'name' => "Tập " . $this->name,
        ]);

        JsonLdMulti::newJsonLd()
            ->setType('BreadcrumbList')
            ->addValue('name', '')
            ->addValue('description', '')
            ->addValue('itemListElement', $breadcrumb);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function movie()
    {
        return $this->belongsTo(Movie::class);
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
