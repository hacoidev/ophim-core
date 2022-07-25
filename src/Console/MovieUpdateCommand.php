<?php

namespace Ophim\Core\Console;

use Illuminate\Console\Command;
use Ophim\Core\Crawler\BaseScheduledCrawler;
use Ophim\Core\Models\CrawlSchedule;

class MovieUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update movie command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schedules = CrawlSchedule::shouldRun()->get();

        foreach ($schedules as $schedule) {
            $handler = $schedule->type;

            if (!class_exists($handler) || !is_subclass_of($handler, BaseScheduledCrawler::class)) {
                throw new \Exception("Crawler does not exists or is not instance of BaseScheduledCrawler");
            }

            (new  $handler($schedule))->execute();
        }

        return 0;
    }
}
