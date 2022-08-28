<?php

namespace Ophim\Core;

use Exception;
use Ophim\Core\Models\Theme as ThemeModel;

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

        $this->name  = ThemeModel::getActivatedTheme()->name;

        if (is_null($this->name)) {
            throw new \Exception("Not found any theme. Please install and active one.");;
        }

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
