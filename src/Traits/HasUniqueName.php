<?php

namespace Ophim\Core\Traits;

use Illuminate\Support\Str;

trait HasUniqueName
{
    /**
     * Require "name" and "name_md5" filed
     *
     * @return void
     */
    public static function bootHasUniqueName()
    {
        static::creating(function ($instance) {
            $instance->name_md5 = md5($instance->name);
        });

        static::updating(function ($instance) {
            $instance->name_md5 = md5($instance->name);
        });
    }
}
