<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\Settings\app\Models\Setting;
use Ophim\Core\Contracts\HasUrlInterface;
use Hacoidev\CachingModel\Contracts\Cacheable;
use Hacoidev\CachingModel\HasCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Ophim\Core\Traits\HasFactory;

class Episode extends Model implements Cacheable, HasUrlInterface
{
    use CrudTrait;
    use HasFactory;
    use HasCache;

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

    public function getTitle()
    {
        $pattern = Setting::get('site.episode.watch.title', '');

        $pattern = str_replace('{movie.name}', $this->movie->name, $pattern);
        $pattern = str_replace('{name}', $this->name, $pattern);

        return $pattern;
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
