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

Route::post('/register', 'RegisterController@register');
Route::post('/login', 'LoginController@login');

Route::group(['middleware' => ['auth:api']], function()
{
    Route::post('/logout', 'LoginController@logout');

    Route::get('/users/{username}', 'UsersController@getUser');
    Route::patch('/users/{username}', 'UsersController@getUser');

    Route::get('/test', function () {
        return "ZDRAVO";
    });
});
