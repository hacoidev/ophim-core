<?php

use Backpack\Settings\app\Models\Setting;

if (!function_exists('get_theme_var')) {
    function get_theme_var($key, $fallback = null)
    {
        $theme = Setting::get('site.theme') ?? config('ophim.theme', 'default');

        $setting = Setting::get('themes.' . $theme . '.customize');

        if (is_null($setting)) return $fallback;

        $props = json_decode($setting, true);

        return isset($props[$key]) ? $props[$key] : $fallback;
    }
}

if (!function_exists('get_crawler_var')) {
    function get_crawler_var($name, $key, $fallback = null)
    {
        $setting = Setting::get('crawlers.' . strtolower($name) . '.options');

        if (is_null($setting)) return $fallback;

        $props = json_decode($setting, true);

        return isset($props[$key]) ? $props[$key] : $fallback;
    }
}
