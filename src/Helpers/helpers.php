<?php

use Backpack\Settings\app\Models\Setting;
use Ophim\Core\Models\Theme;

if (!function_exists('get_theme_option')) {
    function get_theme_option($key, $fallback = null)
    {
        $theme = Theme::getActivatedTheme();

        if (is_null($theme)) return $fallback;

        $props = collect(array_merge(
            array_column($theme->options, 'value', 'name') ?? [],
            is_array($theme->value) ? $theme->value : []
        ));

        return $props[$key] ?? $fallback;
    }
}
