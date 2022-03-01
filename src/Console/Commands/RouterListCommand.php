<?php

namespace Samchentw\Common\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;

/**
 * Url 與controller 對照表
 * @author Sam
 */
class RouterListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'output:router-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'router list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $config = config('common.router_list_methods', [
            "GET",
            "HEAD",
            "POST",
            "PUT",
            "PATCH",
            "DELETE"
        ]);

        $routeList = Route::getRoutes();
        $list = $routeList->getRoutesByMethod();
        $methods = collect($list)->keys()->intersect($config)->all();
        $result = collect([]);

        foreach ($methods as $method) {
            $keys = collect($list[$method])->keys();
            foreach ($keys as $data) {
                $controller = $list[$method][$data];
                $conName = $controller->getActionName();
                $name = $controller->getName();
                $url = $data;
                $result->push([
                    'controller' => $conName,
                    'url' => $url,
                    'name' => $name ? $name : '',
                    'method' => $method
                ]);
            }
        }


        $json_string = json_encode($result->all(), JSON_PRETTY_PRINT);
        (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/public/router-list', public_path('router-list'));
        (new Filesystem)->put(public_path('router-list') . '/router-list.json', $json_string, true);

        $url = config('app.url') . '/router-list/index.html';
        dump('Successed!! Url: ' . $url);
        return 0;
    }
}
