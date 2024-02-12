<?php

namespace Ophim\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Ophim\Core\Models\Episode;

class ChangeDomainEpisodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ophim:episode:change_domain_play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change episode domain play stream';

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
        $domains = array(
            'vip.opstream10.com' => ['vie.opstream1.com', 'vie.haiphim.com'],
            'vip.opstream15.com' => ['hd.1080phim.com', 'hd1080.opstream2.com'],
            'vip.opstream14.com' => ['kd.hd-bophim.com', 'kd.opstream3.com'],
            'vip.opstream11.com' => ['1080.hdphimonline.com', '1080.opstream4.com'],
            'vip.opstream16.com' => ['hd.hdbophim.com', 'hdbo.opstream5.com'],
            'vip.opstream12.com' => ['aa.nguonphimmoi.com', 'aa.opstream6.com'],
            'vip.opstream13.com' => ['vie2.opstream7.com'],
            'vip.opstream17.com' => ['vip.opstream8.com'],
        );
        foreach ($domains as $newDomain => $arrOldDomain) {
            foreach ($arrOldDomain as $oldDomain) {
                $this->info("Replace: $oldDomain => $newDomain");
                Episode::where('link', 'LIKE', '%' . $oldDomain . '%')->update(['link' => DB::raw("REPLACE(link, '$oldDomain', '$newDomain')")]);
            }
        }

        $this->info("Replace Done!");
        return 0;
    }
}
