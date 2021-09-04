<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Samchentw\Common\Http\Controllers\API\CommandController;



Route::prefix('command')->name('command.')->middleware(['api'])->group(function () {

    //reset file Storage link api
    Route::get('/storage-link', [CommandController::class, 'storageLink']);


    //clear cache
    Route::get('/clear-cache', [CommandController::class, 'clearCache']);


    //generate key
    Route::get('/generate-key', [CommandController::class, 'generateKey']);


    //run seed
    Route::get('/db-seed', [CommandController::class, 'dbSeed']);


    //run migrate
    Route::get('/migrate', [CommandController::class, 'migrate']);
});
