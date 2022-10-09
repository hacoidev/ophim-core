<?php

namespace Ophim\Core\Console;

use Illuminate\Console\Command;
use Ophim\Core\Database\Seeders\MenusTableSeeder;

class GenerateMenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ophim:menu:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate menu';

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
        $this->call('db:seed', [
            'class' => MenusTableSeeder::class,
        ]);
        $this->info('Menu is generated.');

        return 0;
    }
}
