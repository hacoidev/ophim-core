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
                ->orWhere('at_month', now()->format('m'));
        })->where(function ($q) {
            $q->where('at_week', '*')
                ->orWhere('at_week', now()->weekOfMonth);
        })->where(function ($q) {
            $q->where('at_day', '*')
                ->orWhere('at_day', now()->format('d'))
                ->orWhere('at_day', '*/' . pow(((now()->format('i') + (now()->format('H') - 1) * 60) / (24 * 60)), -1));
        })->where(function ($q) {
            $q->where('at_hour', '*')
                ->orWhere('at_hour', now()->format('H'))
                ->orWhere('at_hour', '*/' . pow(((now()->format('i')-2) / 60), -1));
        })->where(function ($q) {
            $q->where('at_minute', '*')
                ->orWhere('at_minute', now()->format('i'));
        });
    }

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
