<?php

namespace Ophim\Core\Models;

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
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class Region extends Model implements TaxonomyInterface, Cacheable, SeoInterface
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

    protected $table = 'regions';
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

    public static function primaryCacheKey(): string
    {
        return 'slug';
    }

    public function getUrl()
    {
        return route('regions.movies.index', $this->slug);
    }

    protected function titlePattern(): string
    {
        return Setting::get('site.region.title', '');
    }

    public function generateSeoTags()
    {
        SEOMeta::setTitle($this->getTitle())
            ->setDescription(Str::limit($this->content, 150, '...'))
            ->addKeyword(['$keyword'])
            ->setCanonical($this->getUrl())
            ->setPrev(request()->root())
            ->setPrev(request()->root());
        // ->addMeta($meta, $value, 'property');

        OpenGraph::setSiteName(setting('site.meta.siteName'))
            ->setTitle($this->getTitle())
            ->addProperty('type', 'movie')
            ->addProperty('locale', 'vi-VN')
            ->setUrl($this->getUrl())
            ->setDescription(Str::limit($this->content, 150, '...'))
            ->addImages([$this->thumb_url, $this->poster_url]);

        TwitterCard::setSite(setting('site.meta.siteName'))
            ->setTitle($this->getTitle())
            ->setType('movie')
            ->setImage($this->thumb_url)
            ->setDescription(Str::limit($this->content, 150, '...'))
            ->setUrl($this->getUrl());
        // ->addValue($key, $value);

        JsonLdMulti::newJsonLd()
        ->setSite(setting('site.meta.siteName'))
        ->setTitle($this->getTitle())
        ->setType('movie')
        ->setDescription(Str::limit($this->content, 150, '...'))
        ->setUrl($this->getUrl());
    // ->addValue($key, $value);
    }



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
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
