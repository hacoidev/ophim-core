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
        return 'slug';
    }

    public function getUrl()
    {
        return route('movies.show', $this->slug);
    }

    public function generateSeoTags()
    {
        SEOMeta::setTitle($this->getTitle(), false)
            ->setDescription(Str::limit(strip_tags($this->content), 150, '...'))
            ->addKeyword($this->tags()->pluck('name')->toArray())
            ->setCanonical($this->getUrl())
            ->setPrev(request()->root())
            ->setPrev(request()->root());
        // ->addMeta($meta, $value, 'property');

        OpenGraph::setSiteName(setting('site_meta_siteName'))
            ->setTitle($this->getTitle(), false)
            ->addProperty('type', 'movie')
            ->addProperty('locale', 'vi-VN')
            ->addProperty('updated_time', $this->updated_at)
            ->addProperty('url', $this->getUrl())
            ->setDescription(Str::limit(strip_tags($this->content), 150, '...'))
            ->addImages([request()->root() . $this->thumb_url, request()->root() . $this->poster_url]);

        TwitterCard::setSite(setting('site_meta_siteName'))
            ->setTitle($this->getTitle(), false)
            ->setType('movie')
            ->setImage(request()->root() . $this->thumb_url)
            ->setDescription(Str::limit(strip_tags($this->content), 150, '...'))
            ->setUrl($this->getUrl());
        // ->addValue($key, $value);

        JsonLdMulti::newJsonLd()
            ->setSite(setting('site_meta_siteName'))
            ->setTitle($this->getTitle(), false)
            ->setType('movie')
            ->setDescription(Str::limit(strip_tags($this->content), 150, '...'))
            ->setImages([request()->root() . $this->thumb_url, request()->root() . $this->poster_url])
            ->addValue('dateCreated', $this->created_at)
            ->addValue('director', count($this->directors) ? $this->directors()->first()->name : "")
            ->setUrl($this->getUrl());
        // ->addValue($key, $value);
    }

    public function openView($crud = false)
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="'.$this->getUrl().'" data-toggle="tooltip" title="View link"><i class="la la-link"></i> View</a>';
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
