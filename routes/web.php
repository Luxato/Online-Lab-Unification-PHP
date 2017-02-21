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

// Resource for pages
Route::resource('admin/pages', 'Administration\PageController');

Route::get('/', ['uses' => 'Homepage@index', 'as' => 'home']);
Route::post('/worker/do_delete_page', ['middleware' => 'auth', 'uses' => 'Worker@do_delete_page']);

Route::get('/admin', ['middleware' => 'auth', 'uses' => 'Admin@index']);
Route::get('/admin/navigation', ['middleware' => 'auth', 'uses' => 'Admin@navigation']);
//Route::get('/admin/pages', ['middleware' => 'auth', 'uses' => 'Admin@pages']);
Route::get('/admin/page_create', ['middleware' => 'auth', 'uses' => 'Admin@page_create']);
Route::get('/admin/settings', ['middleware' => 'auth', 'uses' => 'Admin@settings']);
Route::get('/admin/languages', ['middleware' => 'auth', 'uses' => 'Admin@languages']);
Route::get('/admin/create_lang', ['middleware' => 'auth', 'uses' => 'Admin@create_lang']);

Route::post('/worker/do_create_language', ['middleware' => 'auth', 'uses' => 'Worker@do_create_language']);
Route::post('/worker/do_delete_language', ['middleware' => 'auth', 'uses' => 'Worker@do_delete_language']);
Route::post('/worker/do_navigation_change_order', ['middleware' => 'auth', 'uses' => 'Worker@do_navigation_change_order']);

Route::group(['middleware' => ['web']], function () {
	Route::auth();
});

/**
 * {locale} - language = {en,sk}
 */
/*Route::get('/contact', ['uses' => 'Contact@index', 'as' => 'contact']);*/
/*Route::get('/3D-model-hydraulickej-sustavy', ['uses' => 'Mockup@index2']);*/


/*Route::get('{lang}', ['uses' => 'Homepage@index', 'as' => 'en']);*/
Route::get('{slug}', ['uses' => 'Homepage@index', 'as' => 'page']);

Route::get('/home', 'HomeController@index');
