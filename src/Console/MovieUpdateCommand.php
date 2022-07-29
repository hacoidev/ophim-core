<?php

namespace Ophim\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Ophim\Core\Crawler\BaseCrawler;
use Ophim\Core\Database\Seeders\MenusTableSeeder;
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
            $this->onSchedule($schedule);
        }

        return 0;
    }

    protected function onSchedule(CrawlSchedule $schedule)
    {
        $handler = $schedule->type;

        if (!class_exists($handler) || !is_subclass_of($handler, BaseCrawler::class)) {
            throw new \Exception("Crawler does not exists or is not instance of BaseCrawler");
        }

        $movieLinks = $handler::getMovieLinks(preg_split('/[\n\r]+/', $schedule->link), $schedule->from_page, $schedule->to_page);

        foreach ($movieLinks as $link) {
            $time = microtime(true);
            try {
                (new $handler($link, $schedule->fields, $schedule->excluded_categories ?? [], $schedule->excluded_regions ?? []))->handle();
                echo "Crawl success {$link} in " . (microtime(true) - $time) . " s </br>";
            } catch (\Exception $e) {
                echo "Crawl error {$link} in " . (microtime(true) - $time) . " s </br>";
                Log::error($e->getMessage());
            }
        }
    }
}
