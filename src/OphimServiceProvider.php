<?php

namespace Ophim\Core;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Ophim\Core\Console\CreateUser;
use Ophim\Core\Console\InstallCommand;
use Ophim\Core\Middleware\CKFinderAuth;

class OphimServiceProvider extends ServiceProvider
{
    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies()
    {
        return [];
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'ophim');

        config(['ckfinder.authentication' => CKFinderAuth::class]);

        config(['ophim.themes' => array_merge(config('ophim.themes', []), [
            'default' => 'Mặc định'
        ])]);
    }

    public function boot()
    {
        $this->registerPolicies();

        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');

        if (config('ophim.loadRoutes')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views/ophim/', 'ophim');

        $this->loadViewsFrom(__DIR__ . '/../resources/views/themes/', 'ophim_themes');

        $this->publishFiles();

        $this->commands([
            InstallCommand::class,
            CreateUser::class
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

        $this->publishes($backpack_menu_contents_view, 'cms_menu_content');
        $this->publishes($ophim_custom_crud, 'ophim_custom_crud');

        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('ophim.php')
        ]);
    }
}
