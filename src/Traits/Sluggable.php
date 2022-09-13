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
                $slug = Str::slug($instance->name) ?: $instance->name;
                $instance->slug = static::where('slug', $slug)->exists()
                    ? sprintf("%s-%s%s", $slug, floor(microtime(true) * 1000), rand(1, 100))
                    : $slug;
            }
        });

        static::updating(function ($instance) {
            if (empty($instance->slug)) {
                $slug = Str::slug($instance->name) ?: $instance->name;
                $instance->slug = static::where('slug', $slug)->exists()
                    ? sprintf("%s-%s%s", $slug, floor(microtime(true) * 1000), rand(1, 100))
                    : $slug;
            }
        });
    }
}
