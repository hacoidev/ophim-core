<?php

namespace Ophim\Core\Console;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Ophim\Core\Database\Seeders\CatalogsTableSeeder;
use Ophim\Core\Database\Seeders\CategoriesTableSeeder;
use Ophim\Core\Database\Seeders\MenusTableSeeder;
use Ophim\Core\Database\Seeders\PermissionsSeeder;
use Ophim\Core\Database\Seeders\RegionsTableSeeder;
use Ophim\Core\Database\Seeders\SettingsTableSeeder;
use Ophim\Core\Database\Seeders\ThemesTableSeeder;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ophim:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Ophim';

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
        $this->progressBar = $this->output->createProgressBar(18);
        $this->progressBar->minSecondsBetweenRedraws(0);
        $this->progressBar->maxSecondsBetweenRedraws(120);
        $this->progressBar->setRedrawFrequency(1);

        $this->progressBar->start();

        $this->call('vendor:publish', [
            '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
            '--tag' => 'config',
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('vendor:publish', [
            '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
            '--tag' => 'config',
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('vendor:publish', [
            '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
            '--tag' => 'public',
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('vendor:publish', [
            '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
            '--tag' => 'gravatar',
        ]);
        $this->progressBar->advance();
        $this->newLine(1);


        $this->call('migrate', $this->option('no-interaction') ? ['--no-interaction' => true] : []);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('backpack:publish-middleware');
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('vendor:publish', [
            '--tag' => 'cms_menu_content',
            '--force' => true
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('vendor:publish', [
            '--tag' => 'players',
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->installCKfinder();
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('db:seed', [
            'class' => SettingsTableSeeder::class,
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('db:seed', [
            'class' => CatalogsTableSeeder::class,
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('db:seed', [
            'class' => MenusTableSeeder::class,
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('db:seed', [
            'class' => PermissionsSeeder::class,
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->progressBar->finish();
        $this->newLine(1);
        $this->info('Ophim installation finished.');

        return 0;
    }

    protected function installCKfinder()
    {
        $this->call('ckfinder:download');
        $this->call('vendor:publish', [
            '--tag' => 'ckfinder-assets',
        ]);
        $this->progressBar->advance();
        $this->newLine(1);

        $this->call('vendor:publish', [
            '--tag' => 'ckfinder-config',
        ]);

        $this->call('storage:link');
    }
}
