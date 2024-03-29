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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('movies','MovieController');
Route::resource('reviews','ReviewController');
Route::get('/','MovieController@index');
Route::get('/averageRating/{movieID}','MovieController@averageRating')->name('averageRating');
Route::get('/search','MovieController@search');

Route::post('/upload','MovieController@upload');
