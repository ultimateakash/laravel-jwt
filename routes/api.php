<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function () {

    Route::post('register', 'AuthController@register');
    Route::post('login',    'AuthController@login');

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::get('logout',    'AuthController@logout');
        Route::get('refresh',   'AuthController@refreshToken');
        Route::get('user',      'AuthController@getUser');
    });

    Route::any('{segment}', function () {
        return response()->json([
            'error' => 'Invalid url.'
        ]);
    })->where('segment', '.*');
});
