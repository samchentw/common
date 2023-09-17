<?php

namespace Samchentw\Common\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use ReflectionMethod;
use ReflectionNamedType;

/**
 * @author Sam
 * @todo 重構
 * @todo 加入typescript版本
 */
class ClientCodeGenerator extends Command
{

    private const ACCEPT_TYPE = ['string', 'int', ''];
    private const HAS_BODY_INPUT = ['POST', "PUT"];
    

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'js api client產生器';

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
        $config = [
            "GET",
            "POST",
            "PUT",
            "DELETE"
        ];

        $routeList = Route::getRoutes();
        $list = $routeList->getRoutesByMethod();
        $methods = collect($list)->keys()->intersect($config)->all();
        $result = collect([]);

        foreach ($methods as $method) {
            $urls = collect($list[$method])->keys()->filter(function ($item) {
                return Str::startsWith($item, 'api');
            })->toArray();

            foreach ($urls as $url) {
                $controller = $list[$method][$url];
                $conName = $controller->getActionName();
                [$controllerName, $methodName] = explode('@', $conName);
                $reMethod = new ReflectionMethod($controllerName, $methodName);
                $parameters = collect($reMethod->getParameters())->map(function ($item) {
                    $type = $item->getType();
                    return [
                        "type" => ($type instanceof ReflectionNamedType) ? $type->getName() : '',
                        "name" => $item->getName(),
                    ];
                })->toArray();

                $splitName = explode("\\", $controllerName);
                $targetName = Str::of(collect($splitName)->last())
                    ->replace("Controller", "");

                $result->push([
                    "groupName" => lcfirst($targetName) . "Api",
                    'controller' => $controllerName,
                    'document' => $reMethod->getDocComment(),
                    'paramCount' => $reMethod->getNumberOfParameters(),
                    'url' => $url,
                    'method' => $method,
                    'parameters' => $parameters ?? "[]",
                    "methodName" => $reMethod->getShortName()
                ]);
            }
        }

        $apiArray = $result->all();
        // $json_string = json_encode($apiArray, JSON_PRETTY_PRINT);
        // (new Filesystem)->put(public_path('router-list') . '/router-list.json', $json_string, true);
        $groups = collect($apiArray)->groupBy("groupName")->toArray();

        foreach ($groups as $key => $items) {
            $jsMethod = "";
            foreach ($items as $input) {
                $p = collect($input['parameters'])->filter(function ($item) {
                    return in_array($item['type'], self::ACCEPT_TYPE);
                })->map(function ($item) {
                    return $item['name'];
                })->toArray();

                if (in_array($input['method'], self::HAS_BODY_INPUT)) {
                    array_push($p, "data");
                }

                array_push($p, "query = {}");
                $jsMethod .= $this->makeJSMethod(
                    '/' . $input['url'],
                    $input['methodName'],
                    $input['method'],
                    $p,
                    $input['document']
                );
            }
            $fileName = "/{$key}.js";
            $controllerPath = $items[0]['controller'];
            $fileContent = "/**
* 此為程式碼產生器生產請勿修改
* BackendFilePath: {$controllerPath}
* FileName: {$fileName}
* 
* 說明：
* @bodyParam 為物件data參數
* @queryParam 為物件query參數
*/
import axios from 'axios';

export default {
    {$jsMethod}
}
            ";

            (new Filesystem)->put(config('common.generate_path', resource_path('js/API')) . $fileName, $fileContent, true);
            dump($fileName . ' 建立成功!!');
        }

        return 0;
    }


    private function makeJSMethod(string $url, string $methodName, string $method, array $parameters, string $doc = ''): string
    {
        $paramStr = collect($parameters)->map(function ($item) {
            return $item;
        })->join(', ');
        $methodDown = strtolower($method);

        $methodCase = "";

        $newUrl = Str::replace("{", "\${", $url);
        switch ($method) {
            case "GET":
                $methodCase = "return axios.{$methodDown}(`{$newUrl}`, { params: query });";
                break;
            case "POST":
                $methodCase = "return axios.{$methodDown}(`{$newUrl}`, data, { params: query });";
                break;
            case "PUT":
                $methodCase = "return axios.{$methodDown}(`{$newUrl}`, data, { params: query });";
                break;
            case "DELETE":
                $methodCase = "return axios.{$methodDown}(`{$newUrl}`, { params: query });";
                break;
        }

        return "
    {$doc}
    {$methodName}({$paramStr}) {
        {$methodCase}
    },
        ";
    }
}
