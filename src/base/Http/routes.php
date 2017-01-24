<?php

/**
 * Front
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('pages', function () {
        return view('ohio-core::base.front.home');
    });
});

/**
 * Admin
 */
Route::group([
    'prefix' => 'admin/ohio/storage',
    'middleware' => ['web', 'ohio.admin']
],
    function () {
        Route::get('{a?}/{b?}/{c?}', function () {
            return view('ohio-storage::base.admin.dashboard');
        });
    }
);