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
            [
                'key'         => 'site_image_proxy_url',
                'description' => 'site_image_proxy_url',
                'name'        => 'Cấu hình proxy',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => '{image_url}: biến hình ảnh'
                ]),
                'value' => 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&refresh=604800&url={image_url}',
                'active'      => 0,
            ],
            [
                'key'           => 'site_image_proxy_enable',
                'description'   => 'site_image_proxy_enable',
                'name'          => 'Sử dụng Proxy cho đường dẫn hình ảnh',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'switch',
                    'label'         => 'Use proxy link in image path',
                    'color'         => 'primary', // May be any bootstrap color class or an hex color
                    'onLabel'       => '✓',
                    'offLabel'      => '✕'
                ]),
                'active'      => 0,
            ]
        ];

        $metas = [
            [
                'key'         => 'site_meta_siteName',
                'description' => 'site_meta_siteName',
                'name'        => 'Meta site name',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'tab' => 'General'
                ]),
                'value' => 'Ophim.TV',
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_shortcut_icon',
                'description' => 'site_meta_shortcut_icon',
                'name'        => 'Meta shortcut icon',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                    'tab' => 'General'
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_homepage_title',
                'description' => 'site_homepage_title',
                'name'        => 'Tiêu đề mặc định',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'tab' => 'General'
                ]),
                'value' => 'Phim hay mới cập nhật 2022',
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_description',
                'description' => 'site_meta_description',
                'name'        => 'Meta description',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                    'tab' => 'General'
                ]),
                'value' => 'Ophim.TV',
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_keywords',
                'description' => 'site_meta_keywords',
                'name'        => 'Meta keywords',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                    'tab' => 'General'
                ]),
                'value' => 'Ophim.TV',
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_image',
                'description' => 'site_meta_image',
                'name'        => 'Meta image',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'ckfinder',
                    'tab' => 'General'
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_meta_head_tags',
                'description' => 'site_meta_head_tags',
                'name'        => 'Head meta tags',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'textarea',
                    'tab' => 'General',
                    'attributes' => [
                        'rows' => 5
                    ],
                ]),
                'value' => <<<EOT
                <meta charSet="utf-8" />
                <meta name="viewport" content="initial-scale=1.0, width=device-width" />
                <meta name="robots" content="index,follow" />
                <meta name="revisit-after" content="1 days" />
                <meta name="ROBOTS" content="index,follow" />
                <meta name="googlebot" content="index,follow" />
                <meta name="BingBOT" content="index,follow" />
                <meta name="yahooBOT" content="index,follow" />
                <meta name="slurp" content="index,follow" />
                <meta name="msnbot" content="index,follow" />
                EOT,
                'active'      => 0,
            ],
            [
                'key'         => 'site_movie_title',
                'description' => 'site_movie_title',
                'name'        => 'Mẫu tiêu đề trang thông tin phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin phim: {name}|{origin_name}|{language}|{quality}|{episode_current}|{publish_year}|...',
                    'tab' => 'Phim'
                ]),
                'value' => 'Phim {name}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_episode_watch_title',
                'description' => 'site_episode_watch_title',
                'name'        => 'Mẫu tiêu đề trang xem phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin phim: {movie.name}|{movie.origin_name}|{movie.language}|{movie.quality}|{movie.episode_current}|movie.publish_year}|...<br />Thông tin tập: {name}',
                    'tab' => 'Phim'
                ]),
                'value' => 'Xem phim {movie.name} tập {name} {movie.language} {movie.quality}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_category_title',
                'description' => 'site_category_title',
                'name'        => 'Tiêu đề thể loại mặc định',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Thể Loại'
                ]),
                'value' => 'Danh sách phim {name} - tổng hợp phim {name}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_category_des',
                'description' => 'site_category_des',
                'name'        => 'Description thể loại mặc định',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Thể Loại'
                ]),
                'value' => 'Phim {name} mới nhất tuyển chọn hay nhất. Top những bộ phim {name} đáng để bạn cày 2022',
                'active'      => 0,
            ],
            [
                'key'         => 'site_category_key',
                'description' => 'site_category_key',
                'name'        => 'Keywords thể loại mặc định',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Thể Loại'
                ]),
                'value' => 'Xem phim {name},Phim {name} mới,Phim {name} 2022,phim hay',
                'active'      => 0,
            ],
            [
                'key'         => 'site_region_title',
                'description' => 'site_region_title',
                'name'        => 'Tiêu đề quốc gia mặc định',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Quốc Gia'
                ]),
                'value' => 'Danh sách phim {name} - tổng hợp phim {name}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_region_des',
                'description' => 'site_region_des',
                'name'        => 'Description quốc gia mặc định',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Quốc Gia'
                ]),
                'value' => 'Phim {name} mới nhất tuyển chọn hay nhất. Top những bộ phim {name} đáng để bạn cày 2022',
                'active'      => 0,
            ],
            [
                'key'         => 'site_region_key',
                'description' => 'site_region_key',
                'name'        => 'Keywords quốc gia mặc định',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Quốc Gia'
                ]),
                'value' => 'Xem phim {name},Phim {name} mới,Phim {name} 2022,phim hay',
                'active'      => 0,
            ],
            [
                'key'         => 'site_studio_title',
                'description' => 'site_studio_title',
                'name'        => 'Tiêu đề studio',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Studio'
                ]),
                'value' => 'Danh sách phim {name} - tổng hợp phim {name}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_studio_des',
                'description' => 'site_studio_des',
                'name'        => 'Description studio',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Studio'
                ]),
                'value' => 'Phim {name} mới nhất tuyển chọn hay nhất. Top những bộ phim {name} đáng để bạn cày 2022',
                'active'      => 0,
            ],
            [
                'key'         => 'site_studio_key',
                'description' => 'site_studio_key',
                'name'        => 'Keywords studio',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Studio'
                ]),
                'value' => 'Xem phim {name},Phim {name} mới,Phim {name} 2022,phim hay',
                'active'      => 0,
            ],
            [
                'key'         => 'site_actor_title',
                'description' => 'site_actor_title',
                'name'        => 'Tiêu đề diễn viên',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Diễn Viên'
                ]),
                'value' => 'Phim của diễn viên {name} - tổng hợp phim {name} hay nhất',
                'active'      => 0,
            ],
            [
                'key'         => 'site_actor_des',
                'description' => 'site_actor_des',
                'name'        => 'Description diễn viên',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Diễn Viên'
                ]),
                'value' => 'Phim của diễn viên {name} - tổng hợp phim {name} hay nhất',
                'active'      => 0,
            ],
            [
                'key'         => 'site_actor_key',
                'description' => 'site_actor_key',
                'name'        => 'Keywords diễn viên',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Diễn Viên'
                ]),
                'value' => 'xem phim {name},phim {name},tuyen tap phim {name}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_director_title',
                'description' => 'site_director_title',
                'name'        => 'Tiêu đề đạo diễn',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Đạo Diễn'
                ]),
                'value' => 'Phim của đạo diễn {name} - tổng hợp phim {name} hay nhất',
                'active'      => 0,
            ],
            [
                'key'         => 'site_director_des',
                'description' => 'site_director_des',
                'name'        => 'Description đạo diễn',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Đạo Diễn'
                ]),
                'value' => 'Phim của đạo diễn {name} - tổng hợp phim {name} hay nhất',
                'active'      => 0,
            ],
            [
                'key'         => 'site_director_key',
                'description' => 'site_director_key',
                'name'        => 'Keywords đạo diễn',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Đạo Diễn'
                ]),
                'value' => 'xem phim {name},phim {name},tuyen tap phim {name}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_tag_title',
                'description' => 'site_tag_title',
                'name'        => 'Tiêu đề tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Tag'
                ]),
                'value' => 'Phim {name} vietsub - phim {name} full hd',
                'active'      => 0,
            ],
            [
                'key'         => 'site_tag_des',
                'description' => 'site_tag_des',
                'name'        => 'Description tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Tag'
                ]),
                'value' => 'Phim {name} vietsub - phim {name} full hd',
                'active'      => 0,
            ],
            [
                'key'         => 'site_tag_key',
                'description' => 'site_tag_key',
                'name'        => 'Keywords tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => 'Thông tin: {name}',
                    'tab' => 'Tag'
                ]),
                'value' => 'xem phim {name},phim {name},{name} vietsub',
                'active'      => 0,
            ],
            [
                'key'         => 'site_routes_movie',
                'description' => 'site_routes_movie',
                'name'        => 'Trang thông tin phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => '<span class="text-danger">{movie}, {id}</span> Buộc phải có ít nhất 1 param',
                    'tab' => 'Slug'
                ]),
                'value' => '/phim/{movie}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_routes_episode',
                'description' => 'site_routes_episode',
                'name'        => 'Trang xem phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => <<<EOT
                    <span class="text-danger">{movie}, {movie_id}</span> Ít nhất 1<br />
                    <span class="text-danger">{episode}, {id}</span> Bắt buộc<br />
                    EOT,
                    'tab' => 'Slug'
                ]),
                'value' => '/phim/{movie}/{episode}-{id}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_routes_category',
                'description' => 'site_routes_category',
                'name'        => 'Trang thể loại',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => <<<EOT
                    <span class="text-danger">{category}, {id}</span> Ít nhất 1
                    EOT,
                    'tab' => 'Slug'
                ]),
                'value' => '/the-loai/{category}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_routes_region',
                'description' => 'site_routes_region',
                'name'        => 'Trang quốc gia',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => <<<EOT
                    <span class="text-danger">{region}, {id}</span> Ít nhất 1
                    EOT,
                    'tab' => 'Slug'
                ]),
                'value' => '/quoc-gia/{region}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_routes_tag',
                'description' => 'site_routes_tag',
                'name'        => 'Trang từ khóa',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => <<<EOT
                    <span class="text-danger">{tag}, {id}</span> Ít nhất 1
                    EOT,
                    'tab' => 'Slug'
                ]),
                'value' => '/tu-khoa/{tag}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_routes_types',
                'description' => 'site_routes_types',
                'name'        => 'Trang danh sách phim',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => <<<EOT
                    <span class="text-danger">{type}, {id}</span> Ít nhất 1
                    EOT,
                    'tab' => 'Slug'
                ]),
                'value' => '/danh-sach/{type}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_routes_actors',
                'description' => 'site_routes_actors',
                'name'        => 'Trang danh diễn viên',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => <<<EOT
                    <span class="text-danger">{actor}, {id}</span> Ít nhất 1
                    EOT,
                    'tab' => 'Slug'
                ]),
                'value' => '/dien-vien/{actor}',
                'active'      => 0,
            ],
            [
                'key'         => 'site_routes_directors',
                'description' => 'site_routes_directors',
                'name'        => 'Trang danh đạo diễn',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                    'hint' => <<<EOT
                    <span class="text-danger">{director}, {id}</span> Ít nhất 1
                    EOT,
                    'tab' => 'Slug'
                ]),
                'value' => '/dao-dien/{director}',
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

        $others = [
            [
                'key'         => 'social_facebook_app_id',
                'description' => 'social_facebook_app_id',
                'name'        => 'Facebook App ID',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'text',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_scripts_facebook_sdk',
                'description' => 'site_scripts_facebook_sdk',
                'name'        => 'Facebook JS SDK script tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'code',
                ]),
                'active'      => 0,
            ],
            [
                'key'         => 'site_scripts_google_analytics',
                'description' => 'site_scripts_google_analytics',
                'name'        => 'Google analytics script tag',
                'field'       => json_encode([
                    'name' => 'value',
                    'type' => 'code',
                ]),
                'active'      => 0,
            ],
        ];

        foreach ($systems as $index => $setting) {
            $result = Setting::firstOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

        foreach ($generals as $index => $setting) {
            $result = Setting::firstOrCreate(collect($setting)->only('key')->toArray(), collect($setting)
                ->merge(['group' => 'generals'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

        foreach ($metas as $index => $setting) {
            $result = Setting::firstOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->merge(['group' => 'metas'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

        foreach ($players as $index => $setting) {
            $result = Setting::firstOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->merge(['group' => 'jwplayer'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

        foreach ($others as $index => $setting) {
            $result = Setting::firstOrCreate(collect($setting)->only('key')->toArray(), collect($setting)->merge(['group' => 'others'])->except('key')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

        // Delete key not using
        $all_settings = array_merge($generals, $metas, $players, $systems, $others);
        $all_settings = array_map( function( $a ) { return $a['key']; }, $all_settings );
        Setting::whereIn('group', ['generals', 'metas', 'players', 'systems', 'others'])->whereNotIn('key', $all_settings)->delete();
    }
}
