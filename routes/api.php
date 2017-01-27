<?php

use Ohio\Storage;

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
        Route::get('files/{id}', Storage\File\Http\Controllers\Api\FilesController::class . '@show');
        Route::put('files/{id}', Storage\File\Http\Controllers\Api\FilesController::class . '@update');
        Route::delete('files/{id}', Storage\File\Http\Controllers\Api\FilesController::class . '@destroy');
        Route::get('files', Storage\File\Http\Controllers\Api\FilesController::class . '@index');
        Route::post('files', Storage\File\Http\Controllers\Api\FilesController::class . '@store');

        # fileables
        Route::group(['prefix' => 'fileables/{fileable_type}/{fileable_id}'], function () {
            Route::get('{id}', Storage\File\Http\Controllers\Api\FileablesController::class . '@show');
            Route::put('{id}', Storage\File\Http\Controllers\Api\FileablesController::class . '@update');
            Route::delete('{id}', Storage\File\Http\Controllers\Api\FileablesController::class . '@destroy');
            Route::get('', Storage\File\Http\Controllers\Api\FileablesController::class . '@index');
            Route::post('', Storage\File\Http\Controllers\Api\FileablesController::class . '@store');
        });

    }
);
