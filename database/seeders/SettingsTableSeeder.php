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
                'active'      => 0,
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
                'value' => 60,
                'active'      => 0,
            ],
            [
                'key'         => 'site.brand',
                'description' => 'site.brand',
                'name'        => 'Site Brand',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site.logo',
                'description' => 'site.logo',
                'name'        => 'Site Logo',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'active'      => 0,
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
                'active'      => 0,
            ],
            [
                'key'         => 'site.movie.title',
                'description' => 'site.movie.title',
                'name'        => 'Mẫu tiêu đề trang thông tin phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Phim {name} | OphimTV.com',
                'active'      => 0,
            ],
            [
                'key'         => 'site.category.title',
                'description' => 'site.category.title',
                'name'        => 'Mẫu tiêu đề theo thể loại',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Danh sách phim {name} - tổng hợp phim {name} | OphimTV.com',
                'active'      => 0,
            ],
            [
                'key'         => 'site.region.title',
                'description' => 'site.region.title',
                'name'        => 'Mẫu tiêu đề quốc gia',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Danh sách phim khu vực {name} - tổng hợp phim {name} | OphimTV.com',
                'active'      => 0,
            ],
            [
                'key'         => 'site.actor.title',
                'description' => 'site.actor.title',
                'name'        => 'Mẫu tiêu đề diễn viên',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => '{name} - tổng hợp phim {name} | OphimTV.com',
                'active'      => 0,
            ],
            [
                'key'         => 'site.director.title',
                'description' => 'site.director.title',
                'name'        => 'Mẫu tiêu đề đạo diễn',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => '{name} - tổng hợp phim {name} | OphimTV.com',
                'active'      => 0,
            ],
            [
                'key'         => 'site.tag.title',
                'description' => 'site.tag.title',
                'name'        => 'Mẫu tiêu đề từ tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => '{name} - tổng hợp phim {name} | OphimTV.com',
                'active'      => 0,
            ],
            [
                'key'         => 'site.studio.title',
                'description' => 'site.studio.title',
                'name'        => 'Mẫu tiêu đề nhà làm phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => '{name} - tổng hợp phim {name} | OphimTV.com',
                'active'      => 0,
            ],
            [
                'key'         => 'site.episode.watch.title',
                'description' => 'site.episode.watch.title',
                'name'        => 'Mẫu tiêu đề trang xem phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Xem phim {movie.name} - tập {name} | OphimTV.com',
                'active'      => 0,
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
                'active'      => 0,
            ],
            [
                'key'         => 'site.meta.shortcut.icon',
                'description' => 'site.meta.shortcut.icon',
                'name'        => 'Meta shortcut icon',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
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
                'active'      => 0,
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
                'active'      => 0,
            ],
            [
                'key'         => 'site.meta.image',
                'description' => 'site.meta.image',
                'name'        => 'Meta image',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
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
                'active'      => 0,
            ],
        ];

        $players = [
            [
                'key'         => 'jwplayer.license',
                'description' => 'jwplayer.license',
                'name'        => 'Jwplayer license',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=',
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer.logo.file',
                'description' => 'jwplayer.logo.file',
                'name'        => 'Jwplayer logo image',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer.logo.link',
                'description' => 'jwplayer.logo.link',
                'name'        => 'Jwplayer logo link',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer.logo.position',
                'description' => 'jwplayer.logo.position',
                'name'        => 'Jwplayer logo position',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'options' => [
                        'top-left' => 'Top left',
                        'top-right' => 'Top right',
                        'bottom-right' => 'Bottom right',
                        'bottom-left' => 'Bottom left',
                        'control-bar' => 'Control bar',
                    ]
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer.advertising.file',
                'description' => 'jwplayer.advertising.file',
                'name'        => 'Jwplayer advertising vast file',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer.advertising.file',
                'description' => 'jwplayer.advertising.file',
                'name'        => 'Jwplayer advertising vast file',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer.advertising.skipoffset',
                'description' => 'jwplayer.advertising.skipoffset',
                'name'        => 'Jwplayer advertising skipoffset',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'number',
                    'hint' => 'giây'
                ]),
                'value' => 5,
                'active'      => 0,
            ],
        ];

        $scripts = [
            [
                'key'         => 'site.scripts.facebook.sdk',
                'description' => 'site.scripts.facebook.sdk',
                'name'        => 'Facebook JS SDK script tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'summernote',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site.scripts.google.analytics',
                'description' => 'site.scripts.google.analytics',
                'name'        => 'Google analytics script tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'summernote',
                ]),
                'active'      => 0,
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

        foreach ($players as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->merge(['group' => 'jwplayer'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }
    }
}
