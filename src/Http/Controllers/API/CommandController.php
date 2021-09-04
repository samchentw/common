<?php

namespace Samchentw\Common\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{

    /**
     * @group CommandController(指令)
     * storageLink
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storageLink()
    {
        Artisan::call('storage:link');
        return response()->json([
            'result' => true
        ]);
    }


    /**
     * @group CommandController(指令)
     * clearCache
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        return response()->json([
            'result' => true
        ]);
    }

    /**
     * @group CommandController(指令)
     * generateKey
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateKey()
    {
        Artisan::call('key:generate');
        return response()->json([
            'result' => true
        ]);
    }

    /**
     * @group CommandController(指令)
     * dbSeed
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dbSeed()
    {
        Artisan::call('db:seed');
        return response()->json([
            'result' => true
        ]);
    }

    /**
     * @group CommandController(指令)
     * migrate
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function migrate()
    {
        Artisan::call('migrate');
        return response()->json([
            'result' => true
        ]);
    }
}
