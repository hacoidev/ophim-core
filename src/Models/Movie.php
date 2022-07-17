<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Ophim\Core\Contracts\TaxonomyInterface;
use Hacoidev\CachingModel\Contracts\Cacheable;
use Hacoidev\CachingModel\HasCache;
use Illuminate\Database\Eloquent\Model;
use Ophim\Core\Traits\ActorLog;
use Ophim\Core\Traits\HasFactory;
use Ophim\Core\Traits\Sluggable;

class Movie extends Model implements TaxonomyInterface, Cacheable
{
    use CrudTrait;
    use ActorLog;
    use Sluggable;
    use HasFactory;
    use HasCache;

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

    public static function primaryCacheKey(): string
    {
        return 'slug';
    }

    public function getUrl()
    {
        return route('movies.show', $this->slug);
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
