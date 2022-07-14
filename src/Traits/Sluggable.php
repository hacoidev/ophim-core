<?php

namespace Ophim\Core\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    /**
     * Require "name" and "slug" field
     *
     * @return void
     */
    public static function bootSluggable()
    {
        static::creating(function ($instance) {
            if (empty($instance->slug)) {
                $instance->slug = static::where('slug', Str::slug($instance->name))->exists()
                    ? sprintf("%s-%s%s", Str::slug($instance->name), floor(microtime(true) * 1000), rand(1, 100))
                    : Str::slug($instance->name);
            }
        });

        static::updating(function ($instance) {
            if (empty($instance->slug)) {
                $instance->slug = static::where('slug', Str::slug($instance->name))->exists()
                    ? sprintf("%s-%s%s", Str::slug($instance->name), floor(microtime(true) * 1000), rand(1, 100))
                    : Str::slug($instance->name);
            }
        });
    }
}
