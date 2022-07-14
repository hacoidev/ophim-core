<?php

namespace Ophim\Core\Database\Seeders;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $settings = [
            [
                'key'         => 'site_theme',
                'name'        => 'Theme',
                'description' => 'Giao diện người dùng trang web',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'select_from_table',
                    'options' => [
                        'table'   => 'themes',
                        'value_by' => 'key',
                        'display_by' => 'name',
                    ]
                ]),
                'active'      => 1,
            ],
        ];

        foreach ($settings as $index => $setting) {
            $result = Setting::updateOrCreate($setting);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted ' . count($settings) . ' settings.');
    }
}
