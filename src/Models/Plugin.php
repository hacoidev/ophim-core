<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\Settings\app\Models\Setting;
use Ophim\Core\Contracts\TaxonomyInterface;
use Hacoidev\CachingModel\Contracts\Cacheable;
use Hacoidev\CachingModel\HasCache;
use Illuminate\Database\Eloquent\Model;
use Ophim\Core\Contracts\SeoInterface;
use Ophim\Core\Traits\HasFactory;
use Ophim\Core\Traits\HasTitle;
use Ophim\Core\Traits\HasUniqueName;
use Ophim\Core\Traits\Sluggable;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class Plugin extends Model implements Cacheable
{
    use CrudTrait;
    use HasFactory;
    use HasCache;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    public function getVersionAttribute()
    {
        if (!\Composer\InstalledVersions::isInstalled($this->package_name)) {
            return 'Unknown';
        }

        return  \PackageVersions\Versions::getVersion($this->package_name);
    }

    public function editBtn($crud = false)
    {
        return '<a href="' . backpack_url("plugin/{$this->id}/edit") . '" class="btn btn-primary">Edit</a>';
    }
}
