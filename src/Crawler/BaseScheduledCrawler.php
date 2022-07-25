<?php

namespace Ophim\Core\Crawler;

use Ophim\Core\Models\CrawlSchedule;

abstract class BaseScheduledCrawler
{
    /**
     * @var CrawlSchedule
     */
    protected $schedule;

    public function __construct(CrawlSchedule $schedule)
    {
        $this->schedule = $schedule;
    }

    abstract public function execute();
}
