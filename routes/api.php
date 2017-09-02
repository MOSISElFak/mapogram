<?php

Route::post('/register', 'RegisterController@register');
Route::post('/login', 'LoginController@login');

Route::get('users/toplist', 'UsersController@topList');
Route::get('/users/{username}', 'UsersController@getUser');


Route::group(['middleware' => ['auth:api']], function()
{
    Route::post('logout', 'LoginController@logout');

    Route::post('users/{username1}/friends/{username2}', 'UsersController@postBecomeFriend');
    Route::patch('users/{username}', 'UsersController@updateUser');

    Route::get('photos/{id}', 'PhotosController@getPhoto');
    Route::post('photos/{id}/comments', 'PhotosController@addComment');
    Route::post('photos/{id}/likes', 'PhotosController@likePhoto');
    Route::get('photos/{location}/{distance}/{categories?}', 'PhotosController@getPhotosInRadius');
    Route::post('photos', 'PhotosController@postPhoto');

    Route::post('location/exchange', 'LocationController@locationExchange');

    Route::get('categories', 'CategoriesController@all');
});
