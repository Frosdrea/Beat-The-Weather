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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Products index by current weather in the city
Route::get('products/recommended/{city}', ['uses' => 'Api\ProductApiController@indexByWeatherInCity', 'as' => 'products.indexByWeatherInCity']);