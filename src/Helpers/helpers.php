<?php

use Ophim\Core\Models\Plugin;
use Ophim\Core\Models\Theme;

if (!function_exists('get_theme_option')) {
    function get_theme_option($key, $fallback = null)
    {
        $theme = Theme::getActivatedTheme();

        if (is_null($theme)) return $fallback;

        $props = collect(array_merge($theme->options ?? [], $theme->value ?? []));

        return $props->firstWhere('name', $key)['value'] ?? $fallback;
    }
}

if (!function_exists('get_plugin_option')) {
    function get_plugin_option($name, $key, $fallback = null)
    {
        $plugin = Plugin::where('name', $name)->first();

        if (is_null($plugin)) return $fallback;

        $props = collect(array_merge($plugin->options ?? [], $plugin->value ?? []));

        return $props->firstWhere('name', $key)['value'] ?? $fallback;
    }
}
