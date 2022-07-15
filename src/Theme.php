<?php

namespace Ophim\Core;

use Exception;

class Theme
{
    protected $name;
    protected $namespace = 'ophim';
    protected $publicPath;
    protected $themePath;
    protected $payload;

    public function __construct(string $name, array $payload = [])
    {
        $this->name = $name;
        $this->payload = $payload;

        $this->themePath = $this->namespace . '::' . 'themes.' . $name;
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
