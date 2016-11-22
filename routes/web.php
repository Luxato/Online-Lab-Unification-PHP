<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
// TODO AUTH ADMIN LOGIN
Route::post('admin/page_create/', 'Admin@do_page_create');

Route::get('/', ['uses' => 'Homepage@index', 'as' => 'home']);

Route::get('/admin', ['middleware' => 'auth', 'uses' => 'Admin@index']);
Route::get('/admin/navigation', ['middleware' => 'auth', 'uses' => 'Admin@navigation']);
Route::get('/admin/pages', ['middleware' => 'auth', 'uses' => 'Admin@pages']);
Route::get('/admin/page_create', ['middleware' => 'auth', 'uses' => 'Admin@page_create']);
Route::get('/admin/settings', ['middleware' => 'auth', 'uses' => 'Admin@settings']);
Route::get('/admin/languages', ['middleware' => 'auth', 'uses' => 'Admin@languages']);
Route::get('/admin/create_lang', ['middleware' => 'auth', 'uses' => 'Admin@create_lang']);
Route::post('/worker/do_create_language', ['middleware' => 'auth', 'uses' => 'Worker@do_create_language']);
Route::group(['middleware' => ['web']], function () {
	Route::auth();
});

/**
 * {locale} - language = {en,sk}
 */
Route::get('/contact', ['uses' => 'Contact@index', 'as' => 'contact']);
Route::get('/test/1', ['uses' => 'Mockup@index']);
Route::get('/test/2', ['uses' => 'Mockup@index2']);
Route::get('/test/3', ['uses' => 'Mockup@index3']);
Route::get('/test/4', ['uses' => 'Mockup@index4']);


Route::get('{lang}', ['uses' => 'Homepage@index', 'as' => 'en']);

Route::get('/home', 'HomeController@index');
