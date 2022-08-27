<?php

namespace Ophim\Core\Console;

use Illuminate\Console\Command;
use Ophim\Core\Models\Plugin;

class InstallPluginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ophim:install:plugin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Ophim plugin';

    protected $progressBar;


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
        $this->progressBar = $this->output->createProgressBar(count(config('plugins', [])));
        $this->progressBar->minSecondsBetweenRedraws(0);
        $this->progressBar->maxSecondsBetweenRedraws(120);
        $this->progressBar->setRedrawFrequency(1);

        $this->progressBar->start();

        foreach (config('plugins', []) as $key => $plugin) {
            $this->progressBar->advance();

            Plugin::firstOrCreate([
                'name' => $plugin['name'],
            ], [
                'display_name' => $plugin['display_name'] ??  $plugin['name'],
                'author' => $plugin['author'] ?? '',
                'package_name' => $plugin['package_name'],
                'handler' => $plugin['handler'],
                'options' => $plugin['options'],
            ]);

            $this->info("Installed {$plugin['name']} plugin");
        }

        $this->progressBar->finish();
        $this->newLine(1);
        $this->info('Done.');

        return 0;
    }
}
