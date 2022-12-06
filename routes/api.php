<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::post('logout', 'Api\AuthController@logout');


    Route::get('fundraising', 'Api\FundraisingController@index');
    Route::get('fundraising/{id}', 'Api\FundraisingController@show');
    Route::post('fundraising', 'Api\FundraisingController@store');
    Route::put('fundraising/{id}', 'Api\FundraisingController@update');
    Route::delete('fundraising/{id}', 'Api\FundraisingController@destroy');
    Route::post('logout', 'Api\AuthController@logout');



    Route::get('user', 'Api\UserController@index');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::delete('user/{id}', 'Api\UserController@destroy');
    Route::post('logout', 'Api\AuthController@logout');
