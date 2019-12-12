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

Route::prefix('post')->group(function () {
    Route::get('', 'PostController@index');
    Route::get('/{slug}', 'PostController@get');
    Route::post('', 'PostController@create');
    Route::delete('/{id}', 'PostController@delete');
    Route::put('/{id}', 'PostController@update');
});