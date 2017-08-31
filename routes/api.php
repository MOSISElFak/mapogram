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

Route::get('/users/{username}', 'UsersController@getUser');


Route::group(['middleware' => ['auth:api']], function()
{
    Route::post('/logout', 'LoginController@logout');

    Route::post('/users/{username1}/friends/{username2}');
    Route::patch('/users/{username}', 'UsersController@getUser');

    Route::get('/photos/{location}/{distance}', 'PhotosController@getPhotosInRadius');
    Route::post('/photos', 'PhotosController@postPhoto');

    Route::post('location/exchange', 'LocationController@locationExchange');

});
