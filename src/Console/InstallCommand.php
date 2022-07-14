<?php

namespace Ophim\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
        $this->progressBar->advance();$this->newLine(1);

        $this->call('vendor:publish', [
            '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
            '--tag' => 'config',
        ]);
        $this->progressBar->advance();$this->newLine(1);

        $this->call('vendor:publish', [
            '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
            '--tag' => 'errors',
        ]);
        $this->progressBar->advance();$this->newLine(1);

        $this->call('vendor:publish', [
            '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
            '--tag' => 'public',
        ]);
        $this->progressBar->advance();$this->newLine(1);

        $this->call('vendor:publish', [
            '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
            '--tag' => 'gravatar',
        ]);
        $this->progressBar->advance();$this->newLine(1);
        

        $this->call('migrate', $this->option('no-interaction') ? ['--no-interaction' => true] : []);
        $this->progressBar->advance();$this->newLine(1);

        $this->call('backpack:publish-middleware');
        $this->progressBar->advance();$this->newLine(1);

        $this->call('vendor:publish', [
            '--tag' => 'ophim_custom_crud',
        ]);
        $this->progressBar->advance();$this->newLine(1);

        $this->call('vendor:publish', [
            '--tag' => 'cms_menu_content',
        ]);
        $this->progressBar->advance();$this->newLine(1);

        $this->call('vendor:publish', [
            '--tag' => 'ckfinder-assets',
        ]);
        $this->progressBar->advance();$this->newLine(1);

        $this->call('vendor:publish', [
            '--tag' => 'ckfinder-config',
        ]);

        $this->call('db:seed', [
            'class' => SettingsTableSeeder::class,
        ]);

        $this->call('db:seed', [
            'class' => CategoriesTableSeeder::class,
        ]);

        $this->call('db:seed', [
            'class' => RegionsTableSeeder::class,
        ]);

        $this->call('db:seed', [
            'class' => ThemesTableSeeder::class,
        ]);

        $this->call('db:seed', [
            'class' => MenusTableSeeder::class,
        ]);

        $this->progressBar->finish();$this->newLine(1);
        $this->info('Ophim installation finished.');

        return 0;
    }
}
