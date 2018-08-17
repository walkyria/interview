<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.main');
});

//Route::get('/users', 'UserController@index');

Route::get('/search-form', 'SearchController@searchForm')->name('searchForm');

Route::post('/search', 'SearchController@search')->name('search');