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
        $movie = Cache::remember("cache_movie_by_id:" . $this->movie_id, 5 * 60, function () {
            return $this->movie;
        });

        return route('episodes.show', ['movie' => $movie->slug, 'episode' => $this->slug, 'id' => $this->id]);
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
        SEOMeta::setTitle($this->getTitle(), false)
            ->setDescription(Str::limit(strip_tags($this->movie->content), 150, '...'))
            ->addKeyword($this->movie->tags()->pluck('name')->toArray())
            ->setCanonical($this->getUrl())
            ->setPrev(request()->root())
            ->setPrev(request()->root());
        // ->addMeta($meta, $value, 'property');

        OpenGraph::setSiteName(setting('site_meta_siteName'))
            ->setTitle($this->getTitle(), false)
            ->addProperty('type', 'episode')
            ->addProperty('locale', 'vi-VN')
            ->addProperty('url', $this->getUrl())
            ->addProperty('updated_time', $this->movie->updated_at)
            ->setDescription(Str::limit(strip_tags($this->movie->content), 150, '...'))
            ->addImages([request()->root() . $this->movie->thumb_url, request()->root() . $this->movie->poster_url]);

        TwitterCard::setSite(setting('site_meta_siteName'))
            ->setTitle($this->getTitle(), false)
            ->setType('episode')
            ->setImages([request()->root() . $this->movie->thumb_url, request()->root() . $this->movie->poster_url])
            ->setDescription(Str::limit(strip_tags($this->movie->content), 150, '...'))
            ->setUrl($this->getUrl());
        // ->addValue($key, $value);

        JsonLdMulti::newJsonLd()
            ->setSite(setting('site_meta_siteName'))
            ->setTitle($this->getTitle(), false)
            ->setType('episode')
            ->setImages([request()->root() . $this->movie->thumb_url, request()->root() . $this->movie->poster_url])
            ->setDescription(Str::limit(strip_tags($this->movie->content), 150, '...'))
            ->addValue('dateCreated', $this->movie->created_at)
            ->addValue('director', count($this->movie->directors) ? $this->movie->directors()->first()->name : "")
            ->setUrl($this->getUrl());
        // ->addValue($key, $value);
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
