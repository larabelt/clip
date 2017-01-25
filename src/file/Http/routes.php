<?php

use Ohio\Storage\File;

/**
 * API
 */
Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['ohio.api']
],
    function () {
        Route::get('files/{id}', File\Http\Controllers\Api\FilesController::class . '@show');
        Route::put('files/{id}', File\Http\Controllers\Api\FilesController::class . '@update')->middleware('ohio.api.admin');
        Route::delete('files/{id}', File\Http\Controllers\Api\FilesController::class . '@destroy')->middleware('ohio.api.admin');
        Route::get('files', File\Http\Controllers\Api\FilesController::class . '@index')->middleware('ohio.api.admin');
        Route::post('files', File\Http\Controllers\Api\FilesController::class . '@store')->middleware('ohio.api.admin');

        Route::group(['prefix' => 'fileables/{fileable_type}/{fileable_id}'], function () {
            Route::get('{id}', File\Http\Controllers\Api\FileablesController::class . '@show');
            Route::put('{id}', File\Http\Controllers\Api\FileablesController::class . '@update')->middleware('ohio.api.admin');
            Route::delete('{id}', File\Http\Controllers\Api\FileablesController::class . '@destroy')->middleware('ohio.api.admin');
            Route::get('', File\Http\Controllers\Api\FileablesController::class . '@index');
            Route::post('', File\Http\Controllers\Api\FileablesController::class . '@store')->middleware('ohio.api.admin');
        });
    }
);