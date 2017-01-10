<?php

use Ohio\Storage\File;

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {
        Route::get('files/{id}', File\Http\Controllers\Api\FilesController::class . '@show');
        Route::put('files/{id}', File\Http\Controllers\Api\FilesController::class . '@update');
        Route::delete('files/{id}', File\Http\Controllers\Api\FilesController::class . '@destroy');
        Route::get('files', File\Http\Controllers\Api\FilesController::class . '@index');
        Route::post('files', File\Http\Controllers\Api\FilesController::class . '@store');

        Route::group(['prefix' => 'fileables/{fileable_type}/{fileable_id}'], function () {
            Route::get('{id}', File\Http\Controllers\Api\FileablesController::class . '@show');
            Route::delete('{id}', File\Http\Controllers\Api\FileablesController::class . '@destroy');
            Route::get('', File\Http\Controllers\Api\FileablesController::class . '@index');
            Route::post('', File\Http\Controllers\Api\FileablesController::class . '@store');
        });
    }
);