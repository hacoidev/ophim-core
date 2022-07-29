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
            [
                'key'         => 'site.footer',
                'description' => 'site.footer',
                'name'        => 'Footer',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                    'attributes' => [
                        'rows' => 20
                    ]
                ]),
                'value' => '
                    <div class="w-full mx-auto flex flex-wrap">
                        <div class="flex w-full">
                            <div class="px-2"><span class="font-bold text-gray-100">Giới Thiệu...</span>
                                <p class="text-gray-300 text-sm">Xem phim online chất lượng cao miễn phí với phụ đề tiếng
                                    việt - thuyết minh - lồng tiếng, có nhiều thể loại phim phong phú, đặc sắc,
                                    nhiều bộ phim hay nhất - mới nhất.</p>
                                <p class="text-gray-300 text-sm">Website với giao diện trực quan, thuận tiện,
                                    tốc độ tải nhanh, ít quảng cáo hứa hẹn sẽ đem lại những trải nghiệm tốt cho người dùng.
                                </p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="px-2 space-x-2"><a class="text-gray-500">Liên Hệ</a>
                                <a class="text-[#44e2ff] hover:text-yellow-300" href="/ban-quyen">Khiếu nại bản
                                    quyền</a>
                                <ul class="list-reset items-center text-sm pt-3">
                                    <li class="text-gray-300"></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    </div>',
                'active'      => 1,
            ]
        ];

        $themes = [
            // [
            //     'key'         => 'site.movies.latest',
            //     'name'        => 'Danh sách phim mới cập nhật',
            //     'description' => 'site.movies.latest',
            //     'field'       => json_encode([
            //         'name' => 'value',
            //         'type' => 'textarea',
            //         'hint' => 'display_label:relation:find_by_field:value:limit:show_more_url',
            //     ]),
            //     'value' => 'Phim bộ mới::type:series:8:/danh-sach/phim-bo',
            //     'active'      => 1,
            // ],
            // [
            //     'key'         => 'site.movies.tops',
            //     'name'        => 'Bảng xếp hạng phim',
            //     'description' => 'site.movies.tops',
            //     'field'       => json_encode([
            //         'name' => 'value',
            //         'type' => 'textarea',
            //         'hint' => 'display_label:relation:find_by_field:value:sort_by_field:sort_algo:limit',
            //     ]),
            //     'value' => 'Top phim bộ::type:series:view_total:desc:4
            //     Top phim lẻ::type:single:view_total:desc:4',
            //     'active'      => 1,
            // ],
            // [
            //     'key'         => 'site.movies.recommendations.limit',
            //     'name'        => 'Giới hạn phim đề cử trên slider',
            //     'description' => 'site.movies.recommendations.limit',
            //     'field'       => json_encode([
            //         'name' => 'value',
            //         'type' => 'number',
            //     ]),
            //     'active'      => 1,
            // ],
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

        foreach ($themes as $index => $setting) {
            $result = Setting::updateOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->merge(['group' => 'themes'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }
    }
}
