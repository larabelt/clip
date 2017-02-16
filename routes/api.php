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
        Route::get('files/{id}', Clip\Http\Controllers\Api\FilesController::class . '@show');
        Route::put('files/{id}', Clip\Http\Controllers\Api\FilesController::class . '@update');
        Route::delete('files/{id}', Clip\Http\Controllers\Api\FilesController::class . '@destroy');
        Route::get('files', Clip\Http\Controllers\Api\FilesController::class . '@index');
        Route::post('files', Clip\Http\Controllers\Api\FilesController::class . '@store');

        # clippables
        Route::group(['prefix' => 'clippables/{clippable_type}/{clippable_id}'], function () {
            Route::get('{id}', Clip\Http\Controllers\Api\ClippablesController::class . '@show');
            Route::put('{id}', Clip\Http\Controllers\Api\ClippablesController::class . '@update');
            Route::delete('{id}', Clip\Http\Controllers\Api\ClippablesController::class . '@destroy');
            Route::get('', Clip\Http\Controllers\Api\ClippablesController::class . '@index');
            Route::post('', Clip\Http\Controllers\Api\ClippablesController::class . '@store');
        });

    }
);
