<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1.0'], function () {
    Route::get('/', 'ApiController@apiStatus');

    Route::group(['prefix' => 'user'], function () {
        
        Route::post('/sing-up', 'UserController@userRegister');
        Route::post('/sing-in', 'UserController@userToken');

        Route::group(['middleware' => ['auth:api']], function () {
            Route::post('/refresh', 'UserController@userToken');
            Route::get('/', 'UserController@user');
        });
    });

});
