<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Ophim\Core\Traits\ActorLog;
use Ophim\Core\Traits\Sluggable;

class Movie extends Model
{
    use CrudTrait;
    use ActorLog;
    use Sluggable;

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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
