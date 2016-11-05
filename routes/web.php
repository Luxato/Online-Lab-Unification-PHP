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
Route::get('/', ['uses' => 'Homepage@index', 'as' => 'home']);

Route::get('/admin', ['middleware' => 'auth', 'uses' => 'Admin@index']);
Route::group(['middleware' => ['web']], function () {
	Route::auth();
});
/**
 * {locale} - language = {en,sk}
 */
Route::get('/contact', ['uses' => 'Contact@index', 'as' => 'contact']);
Route::get('/test', ['uses' => 'Mockup@index']);


/*Route::get('{lang}', ['uses' => 'Homepage@index', 'as' => 'en']);*/

Route::get('/home', 'HomeController@index');
