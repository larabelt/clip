<?php

use Ohio\Core;

Route::group([
    'prefix' => 'admin/ohio/storage',
    'middleware' => ['web', 'auth']
],
    function () {

        # admin/ohio/storage home
        Route::get('{any?}', function () {
            return view('ohio-storage::base.admin.dashboard');
        })->where('any', '(.*)');
    }
);