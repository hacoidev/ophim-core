<?php

namespace Ophim\Core;

use Backpack\Settings\app\Models\Setting;

class Ophim
{
    public static function theme(): Theme
    {
        $themeName = Setting::get('site_theme') ?? config('ophim.theme', 'default');

        return new Theme($themeName);
    }
}
