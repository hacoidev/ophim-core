<?php

namespace Ophim\Core\Traits;

trait ActorLog
{
    public static function bootActorLog()
    {
        static::creating(function ($instance) {
            $instance->user_id = auth('backpack')->id() ?: $instance->user_id;
            $instance->user_name = auth('backpack')->user() ? auth('backpack')->user()->name : $instance->username;
        });

        static::updating(function ($instance) {
            $instance->user_id = auth('backpack')->id() ?: $instance->user_id;
            $instance->user_name = auth('backpack')->user() ? auth('backpack')->user()->name : $instance->username;
        });
    }
}
