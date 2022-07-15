<?php

namespace Ophim\Core;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Ophim\Core\Console\CreateUser;
use Ophim\Core\Console\InstallCommand;

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

        config(['ckfinder.authentication' => function () {
            return true;
        }]);
    }

    public function boot()
    {
        $this->registerPolicies();

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views/ophim', 'ophim');

        $this->publishFiles();

        $this->commands([
            InstallCommand::class,
            CreateUser::class
        ]);
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
