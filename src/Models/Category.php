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
use Ophim\Core\Traits\HasDescription;
use Ophim\Core\Traits\HasKeywords;
use Ophim\Core\Traits\Sluggable;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class Category extends Model implements TaxonomyInterface, Cacheable, SeoInterface
{
    use CrudTrait;
    use ActorLog;
    use Sluggable;
    use HasFactory;
    use HasCache;
    use HasTitle;
    use HasDescription;
    use HasKeywords;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';
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
        return route('categories.movies.index', $this->slug);
    }

    protected function titlePattern(): string
    {
        return Setting::get('site_category_title', '');
    }

    protected function descriptionPattern(): string
    {
        return Setting::get('site_category_des', '');
    }

    protected function keywordsPattern(): string
    {
        return Setting::get('site_category_key', '');
    }

    public function generateSeoTags()
    {
        $seo_title = $this->seo_title ?: $this->getTitle();
        $seo_des = Str::limit($this->seo_des ?: $this->getDescription(), 150, '...');
        $seo_key = $this->seo_key ?: $this->getKeywords();

        SEOMeta::setTitle($seo_title, false)
            ->setDescription($seo_des)
            ->addKeyword([$seo_key])
            ->setCanonical($this->getUrl())
            ->setPrev(request()->root())
            ->setPrev(request()->root());
        // ->addMeta($meta, $value, 'property');

        OpenGraph::setSiteName(setting('site_meta_siteName'))
            ->setTitle($seo_title, false)
            ->addProperty('type', 'movie')
            ->addProperty('locale', 'vi-VN')
            ->addProperty('url', $this->getUrl())
            ->setDescription($seo_des)
            ->addImages([$this->thumb_url, $this->poster_url]);

        TwitterCard::setSite(setting('site_meta_siteName'))
            ->setTitle($seo_title, false)
            ->setType('movie')
            ->setImage($this->thumb_url)
            ->setDescription($seo_des)
            ->setUrl($this->getUrl());
        // ->addValue($key, $value);

        JsonLdMulti::newJsonLd()
        ->setSite(setting('site_meta_siteName'))
        ->setTitle($seo_title, false)
        ->setType('movie')
        ->setDescription($seo_des)
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
