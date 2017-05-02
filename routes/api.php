<?php

use Belt\Clip\Http\Controllers\Api;

Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {

        # albums
        Route::get('albums/{id}', Api\AlbumsController::class . '@show');
        Route::put('albums/{id}', Api\AlbumsController::class . '@update');
        Route::delete('albums/{id}', Api\AlbumsController::class . '@destroy');
        Route::get('albums', Api\AlbumsController::class . '@index');
        Route::post('albums', Api\AlbumsController::class . '@store');

        # attachment resizes
        Route::group([
            'prefix' => 'attachments/{attachment}/resizes',
        ], function () {
            Route::get('{resize}', Api\ResizesController::class . '@show');
            Route::put('{resize}', Api\ResizesController::class . '@update');
            Route::delete('{resize}', Api\ResizesController::class . '@destroy');
            Route::post('', Api\ResizesController::class . '@store');
            Route::get('', Api\ResizesController::class . '@index');
        });

        # attachments
        Route::get('attachments/{id}', Api\AttachmentsController::class . '@show');
        Route::put('attachments/{id}', Api\AttachmentsController::class . '@update');
        Route::delete('attachments/{id}', Api\AttachmentsController::class . '@destroy');
        Route::get('attachments', Api\AttachmentsController::class . '@index');
        Route::post('attachments', Api\AttachmentsController::class . '@store');

        # attachable
        Route::group([
            'prefix' => '{attachable_type}/{attachable_id}/attachment',
            'middleware' => 'request.injections:attachable_type,attachable_id'
        ], function () {
            Route::get('{id?}', Api\AttachablesController::class . '@show');
            Route::put('{id?}', Api\AttachablesController::class . '@update');
            Route::delete('{id?}', Api\AttachablesController::class . '@destroy');
            Route::post('', Api\AttachablesController::class . '@store');
        });

        # clippable
        Route::group([
            'prefix' => '{clippable_type}/{clippable_id}/attachments',
            'middleware' => 'request.injections:clippable_type,clippable_id'
        ], function () {
            Route::get('{id}', Api\ClippablesController::class . '@show');
            Route::put('{id}', Api\ClippablesController::class . '@update');
            Route::delete('{id}', Api\ClippablesController::class . '@destroy');
            Route::get('', Api\ClippablesController::class . '@index');
            Route::post('', Api\ClippablesController::class . '@store');
        });
    }
);
