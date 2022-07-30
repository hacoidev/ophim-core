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
        $generals = [
            [
                'key'         => 'site.theme',
                'name'        => 'Theme',
                'description' => 'site.theme',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'select_theme',
                ]),
                'value' => 'default',
                'active'      => 1,
            ],
            [
                'key'         => 'site.cache.ttl',
                'name'        => 'Thời gian lưu cache',
                'description' => 'site.cache.ttl',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'giây (s)',
                ]),
                'active'      => 1,
            ],
            [
                'key'         => 'domain.ophim.api',
                'name'        => 'Ophim API Domain URL',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'active'      => 1,
            ],
            [
                'key'         => 'site.scripts.facebook.sdk',
                'description' => 'site.scripts.facebook.sdk',
                'name'        => 'Facebook JS SDK script tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'active'      => 1,
            ],
            [
                'key'         => 'site.brand',
                'description' => 'site.brand',
                'name'        => 'Site Brand',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'active'      => 1,
            ],
            [
                'key'         => 'site.logo',
                'description' => 'site.logo',
                'name'        => 'Site Logo',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'active'      => 1,
            ],

            [
                'key'         => 'ckfinder.license.name',
                'description' => 'ckfinder.license.name',
                'name'        => 'ckfinder.license.name',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'localhost',
                'active'      => 1,
            ],
            [
                'key'         => 'ckfinder.license.key',
                'description' => 'ckfinder.license.key',
                'name'        => 'ckfinder.license.key',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'LAUAS1L5T6FNWUANJEB74PF9V8SBM',
                'active'      => 1,
            ],
        ];

        $metas = [
            [
                'key'         => 'site.homepage.title',
                'description' => 'site.homepage.title',
                'name'        => 'Tiêu đề trang chủ',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'active'      => 1,
            ],
            [
                'key'         => 'site.episode.title',
                'description' => 'site.episode.title',
                'name'        => 'Mẫu tiêu đề trang thông tin phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Phim {name} | OphimTV.com',
                'active'      => 1,
            ],
            [
                'key'         => 'site.meta.siteName',
                'description' => 'site.meta.siteName',
                'name'        => 'Meta site name',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Ophim.TV',
                'active'      => 1,
            ],
            [
                'key'         => 'site.meta.shortcut.icon',
                'description' => 'site.meta.shortcut.icon',
                'name'        => 'Meta shortcut icon',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 1,
            ],
            [
                'key'         => 'site.meta.keywords',
                'description' => 'site.meta.keywords',
                'name'        => 'Meta keywords',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'value' => 'Ophim.TV',
                'active'      => 1,
            ],
            [
                'key'         => 'site.meta.description',
                'description' => 'site.meta.description',
                'name'        => 'Meta description',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'value' => 'Ophim.TV',
                'active'      => 1,
            ],
            [
                'key'         => 'site.meta.image',
                'description' => 'site.meta.image',
                'name'        => 'Meta image',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 1,
            ],
            [
                'key'         => 'site.episode.meta.image',
                'description' => 'site.episode.meta.image',
                'name'        => 'Episode meta image',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                    'hint' => 'field ảnh của phim: poster_url, thumb_url hoặc link ảnh',
                ]),
                'value' => '{poster_url}',
                'active'      => 1,
            ],
        ];

        foreach ($generals as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)
                ->merge(['group' => 'generals'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        foreach ($metas as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->merge(['group' => 'metas'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }
    }
}
