<?php

use Belt\Core;

Route::group([
    'prefix' => 'admin/belt/storage',
    'middleware' => ['web', 'auth']
],
    function () {

        # admin/belt/storage home
        Route::get('{any?}', function () {
            return view('belt-storage::base.admin.dashboard');
        })->where('any', '(.*)');
    }
);