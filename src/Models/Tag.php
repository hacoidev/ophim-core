<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Ophim\Core\Contracts\TaxonomyInterface;
use Hacoidev\CachingModel\Contracts\Cacheable;
use Hacoidev\CachingModel\HasCache;
use Illuminate\Database\Eloquent\Model;
use Ophim\Core\Traits\HasFactory;
use Ophim\Core\Traits\HasUniqueName;
use Ophim\Core\Traits\Sluggable;

class Tag extends Model implements TaxonomyInterface, Cacheable
{
    use CrudTrait;
    use Sluggable;
    use HasUniqueName;
    use HasFactory;
    use HasCache;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tags';
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
        return route('tags.movies.index', $this->slug);
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
