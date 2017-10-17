<?php

use Belt\Clip\Http\Controllers\Web;

Route::group(['middleware' => ['web']], function () {

    # clippable
    Route::pattern('clippable_id', '[0-9]+');
    Route::group([
        'prefix' => '{clippable_type}/{clippable_id}/attachments',
        'middleware' => 'request.injections:clippable_type,clippable_id'
    ], function () {
        Route::get('{any?}', Web\ClippablesController::class . '@show')->where('any', '(.*)');
    });

});