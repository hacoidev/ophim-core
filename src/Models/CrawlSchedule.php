<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CrawlSchedule extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'crawl_schedules';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'fields' => 'array',
        'exclude_regions' => 'array',
        'exclude_categories' => 'array',
    ];

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

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeShouldRun($query)
    {
        return $query->where(function ($q) {
            $q->where('at_month', '*')
                ->orWhere('at_month', (int) now()->format('m'));
        })->where(function ($q) {
            $q->where('at_week', '*')
                ->orWhere('at_week', (int) now()->weekOfMonth);
        })->where(function ($q) {
            $q->where('at_day', '*')
                ->orWhere('at_day', (int) now()->format('d'));
        })->where(function ($q) {
            $q->where('at_hour', '*')
                ->orWhere('at_hour',(int) now()->format('H'));
        })->where(function ($q) {
            $q->where('at_minute', '*')
                ->orWhere('at_minute', (int) now()->format('i'));
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getHandlerAttribute()
    {
        $updaters = collect(config('ophim.updaters', []))->pluck('name','handler')->toArray();

        return isset($updaters[$this->type]) ? $updaters[$this->type] : '';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
