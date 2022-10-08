<?php

namespace Ophim\Core\Console;

use Illuminate\Console\Command;
use Ophim\Core\Models\Theme;

class InstallThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ophim:install:theme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Ophim theme';

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
        $this->progressBar = $this->output->createProgressBar(count(config('themes', [])));
        $this->progressBar->minSecondsBetweenRedraws(0);
        $this->progressBar->maxSecondsBetweenRedraws(120);
        $this->progressBar->setRedrawFrequency(1);

        $this->progressBar->start();

        foreach (config('themes', []) as $key => $theme) {
            $this->progressBar->advance();
            $this->newLine(1);

            Theme::firstOrCreate([
                'name' => $key,
            ], [
                'display_name' => $theme['display_name'] ??  $theme['name'],
                'preview_image' => $theme['preview_image'] ?: '',
                'author' => $theme['author'] ?: '',
                'package_name' => $theme['package_name'],
            ]);

            $this->info("Installed {$theme['name']} theme");
        }

        $this->progressBar->finish();
        $this->newLine(1);
        $this->info('Done.');

        return 0;
    }
}
