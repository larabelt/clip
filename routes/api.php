<?php

use Belt\Clip\Http\Controllers\Api;

Route::group([
    'prefix' => 'api/v1',
    'middleware' => ['api']
],
    function () {

        # attachments
        Route::get('attachments/{id}', Api\AttachmentsController::class . '@show');
        Route::put('attachments/{id}', Api\AttachmentsController::class . '@update');
        Route::delete('attachments/{id}', Api\AttachmentsController::class . '@destroy');
        Route::get('attachments', Api\AttachmentsController::class . '@index');
        Route::post('attachments', Api\AttachmentsController::class . '@store');

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
