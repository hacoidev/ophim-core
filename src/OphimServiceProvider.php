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
            __DIR__ . '/../resources/views/backpack/base/inc/sidebar_content.blade.php'      => resource_path('views/vendor/backpack/base/inc/sidebar_content.blade.php'),
            __DIR__ . '/../resources/views/backpack/base/inc/topbar_left_content.blade.php'  => resource_path('views/vendor/backpack/base/inc/topbar_left_content.blade.php'),
            __DIR__ . '/../resources/views/backpack/base/inc/topbar_right_content.blade.php' => resource_path('views/vendor/backpack/base/inc/topbar_right_content.blade.php'),
        ];

        $ophim_custom_crud = [
            __DIR__ . '/../resources/views/backpack/crud/fields/'      => resource_path('views/vendor/backpack/crud/fields/'),
            __DIR__ . '/../resources/views/backpack/crud/columns/'      => resource_path('views/vendor/backpack/crud/columns/'),
        ];

        $players = [
            __DIR__ . '/../resources/views/assets/js/inc/hls.min.js' => public_path('js/hls.min.js'),
            __DIR__ . '/../resources/views/assets/js/inc/jwplayer-8.9.3.js' => public_path('js/jwplayer-8.9.3.js'),
            __DIR__ . '/../resources/views/assets/js/inc/hls.min.js' => public_path('js/jwplayer.hlsjs.min.js'),
        ];

        $this->publishes($backpack_menu_contents_view, 'cms_menu_content');
        $this->publishes($ophim_custom_crud, 'ophim_custom_crud');
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

        config(['backpack.base.middleware_class' => array_merge(config('backpack.base.middleware_class'), [
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

        $this->mergeConfigFrom(__DIR__ . '/../config/customizers.php', 'customizers');
    }

    protected function mergePolicies()
    {
        config(['backpack.permissionmanager.policies.permission' => PermissionPolicy::class]);
        config(['backpack.permissionmanager.policies.role' => RolePolicy::class]);
        config(['backpack.permissionmanager.policies.user' => UserPolicy::class]);
    }
}
