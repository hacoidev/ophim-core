<?php

namespace Ophim\Core\Crawler;

abstract class BaseCrawler
{
    protected $link;
    protected $fields;
    protected $excludedCategories;
    protected $excludedRegions;

    public function __construct($link, $fields, $excludedCategories = [], $excludedRegions = [])
    {
        $this->link = $link;
        $this->fields = $fields;
        $this->excludedCategories = $excludedCategories;
        $this->excludedRegions = $excludedRegions;
    }

    abstract public function handle();
}
