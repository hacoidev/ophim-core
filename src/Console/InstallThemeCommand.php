<?php

namespace Ophim\Core\Console;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Ophim\Core\Database\Seeders\CategoriesTableSeeder;
use Ophim\Core\Database\Seeders\MenusTableSeeder;
use Ophim\Core\Database\Seeders\PermissionsSeeder;
use Ophim\Core\Database\Seeders\RegionsTableSeeder;
use Ophim\Core\Database\Seeders\SettingsTableSeeder;
use Ophim\Core\Database\Seeders\ThemesTableSeeder;

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

            $setting = Setting::where('key', "themes.{$key}.customize")->first();

            if (!is_null($setting)) {
                continue;
            }

            $setting = Setting::firstOrCreate([
                'key' => "themes.{$key}.customize",
            ], [
                'name' => $theme['name'],
                'field' => json_encode(['name' => 'value', 'type', 'hidden']),
                'active' => false
            ]);

            $fields = collect($theme['options']);

            $setting->update([
                'value' => $fields->pluck('value', 'name')->toArray()
            ]);
            $this->info("Installed {$theme['name']} theme");
        }

        $this->progressBar->finish();
        $this->newLine(1);
        $this->info('Done.');

        return 0;
    }
}
