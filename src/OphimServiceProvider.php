<?php

namespace Ophim\Core;

use Ophim\Core\Policies\PermissionPolicy;
use Ophim\Core\Policies\RolePolicy;
use Ophim\Core\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Ophim\Core\Console\CreateUser;
use Ophim\Core\Console\InstallCommand;
use Ophim\Core\Console\MovieUpdateCommand;
use Ophim\Core\Middleware\CKFinderAuth;
use Ophim\Core\Models\Actor;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\Director;
use Ophim\Core\Models\Episode;
use Ophim\Core\Models\Menu;
use Ophim\Core\Models\Movie;
use Ophim\Core\Models\Region;
use Ophim\Core\Models\Studio;
use Ophim\Core\Models\Tag;
use Ophim\Core\Policies\ActorPolicy;
use Ophim\Core\Policies\CategoryPolicy;
use Ophim\Core\Policies\CrawlSchedulePolicy;
use Ophim\Core\Policies\DirectorPolicy;
use Ophim\Core\Policies\EpisodePolicy;
use Ophim\Core\Policies\MenuPolicy;
use Ophim\Core\Policies\MoviePolicy;
use Ophim\Core\Policies\RegionPolicy;
use Ophim\Core\Policies\StudioPolicy;
use Ophim\Core\Policies\TagPolicy;

class OphimServiceProvider extends ServiceProvider
{
    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies()
    {
        return [
            Actor::class => ActorPolicy::class,
            Category::class => CategoryPolicy::class,
            Region::class => RegionPolicy::class,
            Director::class => DirectorPolicy::class,
            Tag::class => TagPolicy::class,
            Studio::class => StudioPolicy::class,
            Movie::class => MoviePolicy::class,
            Episode::class => EpisodePolicy::class,
            Menu::class => MenuPolicy::class,
            CrawlSchedule::class => CrawlSchedulePolicy::class
        ];
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'ophim');

        $this->setupDefaultThemeCustomizer();

        $this->mergeBackpackConfigs();

        $this->mergeCkfinderConfigs();

        $this->mergePolicies();
    }

    public function boot()
    {
        $this->registerPolicies();

        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            require_once $filename;
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');

        if (config('ophim.loadRoutes')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views/core/', 'ophim');

        $this->loadViewsFrom(__DIR__ . '/../resources/views/themes', 'themes');

        $this->publishFiles();

        $this->commands([
            InstallCommand::class,
            CreateUser::class,
            MovieUpdateCommand::class
        ]);

        $this->app->bind(Theme::class, function ($app) {
            return new Theme();
        });
    }

    protected function publishFiles()
    {
        $backpack_menu_contents_view = [
            __DIR__ . '/../resources/views/core/base/inc/sidebar_content.blade.php'      => resource_path('views/vendor/hacoidev/base/inc/sidebar_content.blade.php'),
        ];

        $players = [
            __DIR__ . '/../resources/assets/js/hls.min.js' => public_path('js/hls.min.js'),
            __DIR__ . '/../resources/assets/js/jwplayer-8.9.3.js' => public_path('js/jwplayer-8.9.3.js'),
            __DIR__ . '/../resources/assets/js/jwplayer.hlsjs.min.js' => public_path('js/jwplayer.hlsjs.min.js'),
        ];

        $this->publishes($backpack_menu_contents_view, 'cms_menu_content');
        $this->publishes($players, 'players');

        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('ophim.php')
        ], 'config');
    }

    protected function mergeBackpackConfigs()
    {
        config(['backpack.base.styles' => array_merge(config('backpack.base.styles', []), [
            'packages/select2/dist/css/select2.css',
            'packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css'
        ])]);

        config(['backpack.base.scripts' => array_merge(config('backpack.base.scripts', []), [
            'packages/select2/dist/js/select2.full.min.js'
        ])]);

        config(['backpack.base.middleware_class' => array_merge(config('backpack.base.middleware_class', []), [
            \Backpack\CRUD\app\Http\Middleware\UseBackpackAuthGuardInsteadOfDefaultAuthGuard::class,
        ])]);

        config(['backpack.base.project_logo' => '<b>Ophim</b>TV']);
        config(['backpack.base.developer_name' => 'hacoidev']);
        config(['backpack.base.developer_link' => 'mailto:hacoi.dev@gmail.com']);
        config(['backpack.base.show_powered_by' => false]);
    }

    protected function mergeCkfinderConfigs()
    {
        config(['ckfinder.authentication' => CKFinderAuth::class]);
        config(['ckfinder.backends.default' => config('ophim.ckfinder.backends')]);
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['ophim.themes' => array_merge(config('ophim.themes', []), [
            'default' => 'Mặc định'
        ])]);

        config(['customizers' => array_merge(config('customizers', []), [
            'default' => [
                [
                    'name' => 'latest',
                    'label' => 'Danh sách mới cập nhật',
                    'type' => 'textarea',
                    'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url',
                    'value' => 'Phim bộ mới||type|series|8|/danh-sach/phim-bo',
                    'attributes' => [
                        'rows' => 5
                    ]
                ],
                [
                    'name' => 'hotest',
                    'label' => 'Danh sách hot',
                    'type' => 'textarea',
                    'hint' => 'display_label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                    'value' => 'Top phim bộ||type|series|view_total|desc|4',
                    'attributes' => [
                        'rows' => 5
                    ]
                ],
                [
                    'name' => 'footer',
                    'label' => 'Footer',
                    'type' => 'summernote',
                    'value' => <<<EOT
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
                            </div>
                        </div>
                    </div>
                    EOT
                ]
            ],

        ])]);
    }

    protected function mergePolicies()
    {
        config(['backpack.permissionmanager.policies.permission' => PermissionPolicy::class]);
        config(['backpack.permissionmanager.policies.role' => RolePolicy::class]);
        config(['backpack.permissionmanager.policies.user' => UserPolicy::class]);
    }
}
