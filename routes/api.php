<?php

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

/**
 * api/v1 route düzeni başlangıcı
 */
Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {

    //Karşılama için kullanılacak endpoint
    Route::get('', ['uses' =>  'DevicesController@splash', 'as' => 'api.splash']);

    //Token (\App\Http\Middleware\CheckToken) kontrolü ile erişebilecek endpointler
    Route::group(['middleware' => 'token'], function () {

        Route::apiResource('categories', 'CategoryController')->only(['index', 'show']);
        Route::apiResource('favorites', 'FavoritesController')->only(['index', 'store', 'destroy']);
        Route::apiResource('media', 'MediaController')->only(['show']);
        
    });
});
/** 
 * api/v1 route düzeni bitişi
 */
