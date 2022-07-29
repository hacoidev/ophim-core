<?php

use Backpack\Settings\app\Models\Setting;

if (!function_exists('get_theme_attr')) {
    function get_theme_attr($key, $fallback = null)
    {
        $theme = Setting::get('site.theme') ?? config('ophim.theme', 'default');

        $setting = Setting::get('themes.' . $theme . '.customize');

        if (is_null($setting)) return $fallback;

        $props = json_decode($setting, true);

        return isset($props[$key]) ? $props[$key] : $fallback;
    }
}
