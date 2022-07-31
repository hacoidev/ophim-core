<?php

use Backpack\Settings\app\Models\Setting;

if (!function_exists('get_theme_option')) {
    function get_theme_option($key, $fallback = null)
    {
        $theme = Setting::get('site.theme') ?? config('ophim.theme', 'default');

        $setting = Setting::get('themes.' . $theme . '.customize');

        if (is_null($setting)) return $fallback;

        $props = json_decode($setting, true);

        return isset($props[$key]) ? $props[$key] : $fallback;
    }
}

if (!function_exists('get_addon_option')) {
    function get_addon_option($name, $key, $fallback = null)
    {
        $setting = Setting::get('addons.' . strtolower($name) . '.options');

        if (is_null($setting)) return $fallback;

        $props = json_decode($setting, true);

        return isset($props[$key]) ? $props[$key] : $fallback;
    }
}
