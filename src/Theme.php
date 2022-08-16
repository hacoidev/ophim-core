<?php

namespace Ophim\Core;

use Backpack\Settings\app\Models\Setting;
use Exception;

class Theme
{
    protected $name;
    protected $namespace = 'themes';
    protected $publicPath;
    protected $themePath;
    protected $payload;

    public function __construct(array $payload = [])
    {
        $this->payload = $payload;

        $this->name  = Setting::get('site_theme') ?? config('ophim.theme', 'default');
        $this->themePath = $this->namespace . '::' . $this->name;
    }

    public function render($template, array $data = [])
    {
        $viewPath = sprintf("%s.%s", $this->themePath, $template);
        if (!view()->exists($viewPath)) {
            throw new Exception("Theme {$this->name}'s {$template} view  is not installed. Please check your installation");
        }

        return view($viewPath, array_merge($this->payload, $data));
    }

    public function addPayload(array $data)
    {
        $this->payload = array_merge($this->payload, $data);
    }
}
