<?php

use Belt\Core;

Route::group([
    'prefix' => 'admin/belt/clip',
    'middleware' => ['web', 'auth']
],
    function () {

        # admin/belt/clip home
        Route::get('{any?}', function () {
            return view('belt-clip::base.admin.dashboard');
        })->where('any', '(.*)');
    }
);