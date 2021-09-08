<?php

namespace Samchentw\Common;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Samchentw\Common\Console\Commands;

class CommonProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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
