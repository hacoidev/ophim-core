<?php

namespace Ophim\Core\Database\Seeders;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds_
     *
     * @return void
     */
    public function run()
    {
        $generals = [
            [
                'key'         => 'site_cache_ttl',
                'name'        => 'Thời gian lưu cache',
                'description' => 'site_cache_ttl',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'giây (s)',
                ]),
                'value' => 60,
                'active'      => 0,
            ],
            [
                'key'         => 'site_brand',
                'description' => 'site_brand',
                'name'        => 'Site Brand',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_logo',
                'description' => 'site_logo',
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
                'key'         => 'site_homepage_title',
                'description' => 'site_homepage_title',
                'name'        => 'Tiêu đề trang chủ',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_movie_title',
                'description' => 'site_movie_title',
                'name'        => 'Mẫu tiêu đề trang thông tin phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Phim {name} | OphimTV_com',
                'active'      => 0,
            ],
            [
                'key'         => 'site_category_title',
                'description' => 'site_category_title',
                'name'        => 'Mẫu tiêu đề theo thể loại',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Danh sách phim {name} - tổng hợp phim {name} | OphimTV_com',
                'active'      => 0,
            ],
            [
                'key'         => 'site_region_title',
                'description' => 'site_region_title',
                'name'        => 'Mẫu tiêu đề quốc gia',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Danh sách phim khu vực {name} - tổng hợp phim {name} | OphimTV_com',
                'active'      => 0,
            ],
            [
                'key'         => 'site_actor_title',
                'description' => 'site_actor_title',
                'name'        => 'Mẫu tiêu đề diễn viên',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => '{name} - tổng hợp phim {name} | OphimTV_com',
                'active'      => 0,
            ],
            [
                'key'         => 'site_director_title',
                'description' => 'site_director_title',
                'name'        => 'Mẫu tiêu đề đạo diễn',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => '{name} - tổng hợp phim {name} | OphimTV_com',
                'active'      => 0,
            ],
            [
                'key'         => 'site_tag_title',
                'description' => 'site_tag_title',
                'name'        => 'Mẫu tiêu đề từ tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => '{name} - tổng hợp phim {name} | OphimTV_com',
                'active'      => 0,
            ],
            [
                'key'         => 'site_studio_title',
                'description' => 'site_studio_title',
                'name'        => 'Mẫu tiêu đề nhà làm phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => '{name} - tổng hợp phim {name} | OphimTV_com',
                'active'      => 0,
            ],
            [
                'key'         => 'site_episode_watch_title',
                'description' => 'site_episode_watch_title',
                'name'        => 'Mẫu tiêu đề trang xem phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Xem phim {movie_name} - tập {name} | OphimTV_com',
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_siteName',
                'description' => 'site_meta_siteName',
                'name'        => 'Meta site name',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'Ophim_TV',
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_shortcut_icon',
                'description' => 'site_meta_shortcut_icon',
                'name'        => 'Meta shortcut icon',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_keywords',
                'description' => 'site_meta_keywords',
                'name'        => 'Meta keywords',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'value' => 'Ophim_TV',
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_description',
                'description' => 'site_meta_description',
                'name'        => 'Meta description',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                ]),
                'value' => 'Ophim_TV',
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_image',
                'description' => 'site_meta_image',
                'name'        => 'Meta image',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_episode_meta_image',
                'description' => 'site_episode_meta_image',
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
                'key'         => 'jwplayer_license',
                'description' => 'jwplayer_license',
                'name'        => 'Jwplayer license',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'value' => 'ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=',
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer_logo_file',
                'description' => 'jwplayer_logo_file',
                'name'        => 'Jwplayer logo image',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer_logo_link',
                'description' => 'jwplayer_logo_link',
                'name'        => 'Jwplayer logo link',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer_logo_position',
                'description' => 'jwplayer_logo_position',
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
                'key'         => 'jwplayer_advertising_file',
                'description' => 'jwplayer_advertising_file',
                'name'        => 'Jwplayer advertising vast file',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer_advertising_file',
                'description' => 'jwplayer_advertising_file',
                'name'        => 'Jwplayer advertising vast file',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'jwplayer_advertising_skipoffset',
                'description' => 'jwplayer_advertising_skipoffset',
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

        $systems = [
            [
                'key'         => 'site_theme',
                'name'        => 'Theme',
                'description' => 'site_theme',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'view',
                    'view' => 'themes::selector'
                ]),
                'value' => 'default',
                'active'      => 0,
            ],
        ];

        $scripts = [
            [
                'key'         => 'site_scripts_facebook_sdk',
                'description' => 'site_scripts_facebook_sdk',
                'name'        => 'Facebook JS SDK script tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'summernote',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_scripts_google_analytics',
                'description' => 'site_scripts_google_analytics',
                'name'        => 'Google analytics script tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'summernote',
                ]),
                'active'      => 0,
            ],
        ];

        foreach ($systems as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

        foreach ($generals as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)
                ->merge(['group' => 'generals'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

        foreach ($metas as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->merge(['group' => 'metas'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

        foreach ($players as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->merge(['group' => 'jwplayer'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }
    }
}
