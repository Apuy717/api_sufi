<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'API\UserController@details');
    //route article
    Route::post('/article/add', 'ContentController@store');
    Route::post('/article/update/{id}', 'ContentController@update');
    Route::post('/article/delete/{id}', 'ContentController@delete');

    //route gallery
    Route::post('/gallery/add', 'GalleryController@store');
    Route::post('/gallery/update/{id}', 'GalleryController@update');
    Route::post('/gallery/delete/{id}', 'GalleryController@delete');

    //route layang sworo
    Route::post('/sound/add', 'LayangSworo@store');
    Route::post('/sound/update/{id}', 'LayangSworo@update');
    Route::post('/sound/delete/{id}', 'LayangSworo@delete');
});
//end-point no auth token
//article
Route::get('/article', 'ContentController@index');
Route::get('/article/{id}', 'ContentController@byId');

//gallery
Route::get('/gallery/{page}/{limmit}', 'GalleryController@index');
Route::get('/gallery/{id}', 'GalleryController@byId');

//layang sworo
Route::get('/sound', 'LayangSworo@index');
Route::get('/sound/{id}', 'LayangSworo@byId');
