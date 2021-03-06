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

/////////////////////////////////////////
// Register
/////////////////////////////////////////
Route::post('auth/register', 'Api\AuthController@register');

/////////////////////////////////////////
// Login
/////////////////////////////////////////
Route::post('auth/login', 'Api\AuthController@login');

/////////////////////////////////////////
// Logout
/////////////////////////////////////////
Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', 'Api\AuthController@logout');
});