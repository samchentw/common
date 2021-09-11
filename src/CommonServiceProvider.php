<?php

namespace Samchentw\Common;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Samchentw\Common\Console\Commands;
use Illuminate\Database\Schema\Blueprint;
use Samchentw\Common\Helpers\EnableHelper;
use Samchentw\Common\Helpers\SortHelper;

class CommonServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Blueprint::macro('setEnable', function () {
            EnableHelper::columns($this);
        });

        Blueprint::macro('dropEnable', function () {
            EnableHelper::dropColumns($this);
        });

        Blueprint::macro('setSort', function () {
            SortHelper::columns($this);
        });

        Blueprint::macro('dropSort', function () {
            SortHelper::dropColumns($this);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRoutes();
        $this->configureCommands();
        $this->configurePublishing();
    }


    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/common.php' => config_path('common.php'),
        ], 'common-config');
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        Route::group([
            'namespace' => '',
            'domain' => null,
            'prefix' => 'api',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/command.php');
        });
    }



    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Commands\MakeRepositoryCommand::class,
            Commands\MakeHelperCommand::class,
            Commands\MakeServiceCommand::class
        ]);
    }
}
