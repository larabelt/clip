<?php

Route::group([
    'prefix' => 'admin/belt/clip',
    'middleware' => ['web', 'admin']
],
    function () {

        # admin/belt/clip home
        Route::get('{any?}', function () {
            return view('belt-clip::base.admin.dashboard');
        })->where('any', '(.*)');
    }
);