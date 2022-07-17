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
                    'type' => 'select_theme',
                ]),
                'value' => 'vietphimtv',
                'active'      => 1,
            ],
            [
                'key'         => 'index_latest_update_lists',
                'name'        => 'Danh sách phim mới cập nhật',
                'description' => 'Danh sách phim mới cập nhật trên trang chủ',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Phim bộ mới::type:series:8:/danh-sach/phim-bo|',
                'active'      => 1,
            ],
            [
                'key'         => 'site_top_lists',
                'name'        => 'Bảng xếp hạng phim',
                'description' => 'Bảng xếp hạng phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Top phim bộ::type:series:view_total:desc:4|Top phim lẻ::type:single:view_total:desc:4',
                'active'      => 1,
            ],
            [
                'key'         => 'ophim_api_url',
                'name'        => 'Ophim API Domain url',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'https://ophim1.com',
                'active'      => 1,
            ]
        ];

        foreach ($settings as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted ' . count($settings) . ' settings.');
    }
}
