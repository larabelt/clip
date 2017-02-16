<?php

use Belt\Clip;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['web', 'auth', 'api']
],
    function () {

        # files
        Route::get('files/{id}', Storage\Http\Controllers\Api\FilesController::class . '@show');
        Route::put('files/{id}', Storage\Http\Controllers\Api\FilesController::class . '@update');
        Route::delete('files/{id}', Storage\Http\Controllers\Api\FilesController::class . '@destroy');
        Route::get('files', Storage\Http\Controllers\Api\FilesController::class . '@index');
        Route::post('files', Storage\Http\Controllers\Api\FilesController::class . '@store');

        # fileables
        Route::group(['prefix' => 'fileables/{fileable_type}/{fileable_id}'], function () {
            Route::get('{id}', Storage\Http\Controllers\Api\FileablesController::class . '@show');
            Route::put('{id}', Storage\Http\Controllers\Api\FileablesController::class . '@update');
            Route::delete('{id}', Storage\Http\Controllers\Api\FileablesController::class . '@destroy');
            Route::get('', Storage\Http\Controllers\Api\FileablesController::class . '@index');
            Route::post('', Storage\Http\Controllers\Api\FileablesController::class . '@store');
        });

    }
);
