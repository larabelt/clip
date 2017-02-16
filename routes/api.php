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

        # attachments
        Route::get('attachments/{id}', Clip\Http\Controllers\Api\AttachmentsController::class . '@show');
        Route::put('attachments/{id}', Clip\Http\Controllers\Api\AttachmentsController::class . '@update');
        Route::delete('attachments/{id}', Clip\Http\Controllers\Api\AttachmentsController::class . '@destroy');
        Route::get('attachments', Clip\Http\Controllers\Api\AttachmentsController::class . '@index');
        Route::post('attachments', Clip\Http\Controllers\Api\AttachmentsController::class . '@store');

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
