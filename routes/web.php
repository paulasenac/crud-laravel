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

#Admin
Route::group(['middleware' => 'auth', 'prefix' => 'administrator'], function () {
	Route::get('/', 'SiteController@index')->name('admin');
	Route::post('/', 'SiteController@login');
	#users
	Route::group(['prefix' => 'users'], function(){
		Route::get('/', 'UserController@index')->name('users');
		Route::get('/new', 'UserController@add');
		Route::post('/new', 'UserController@addAction');
		Route::get('/edit/{id}', 'UserController@edit');
		Route::post('/edit/{id}', 'UserController@update');
		Route::get('/delete/{id}', 'UserController@remove');
	});
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
