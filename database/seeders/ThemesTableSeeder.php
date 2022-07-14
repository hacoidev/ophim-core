<?php

namespace Ophim\Core\Database\Seeders;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ophim\Core\Models\Theme;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = [
            [
                'key'         => 'default',
                'name'        => 'Mặc định',
            ],
        ];

        foreach ($themes as $index => $theme) {
            $result = Theme::updateOrCreate($theme);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted ' . count($themes) . ' themes.');
    }
}
