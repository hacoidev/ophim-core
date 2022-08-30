<?php

use Backpack\Settings\app\Models\Setting;
use Ophim\Core\Models\Theme;

if (!function_exists('get_theme_option')) {
    function get_theme_option($key, $fallback = null)
    {
        $theme = Theme::getActivatedTheme();

        if (is_null($theme)) return $fallback;

        $props = collect(array_merge($theme->options ?? [], is_array($theme->value) ? $theme->value : []));

        return $props->firstWhere('name', $key)['value'] ?? $fallback;
    }
}

if (!function_exists('get_plugin_option')) {
    function get_plugin_option($name, $key, $fallback = null)
    {
        $setting = Setting::where('key', 'plugin_option_' . $name)->first();

        if (is_null($setting)) return $fallback;

        return $setting->value[$key] ?? $fallback;
    }
}
