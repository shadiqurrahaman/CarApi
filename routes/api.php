<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
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



Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {

    Route::post('cars','CarshopController@savecar');
    Route::get('cars/{id}','CarshopController@getcar');
    Route::post('cars/{id}/years','CarshopController@addyear');
    Route::get('cars','CarshopController@carbyyear');
   
});