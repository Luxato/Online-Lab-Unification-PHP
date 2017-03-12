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
// Resource for news
Route::resource('admin/news', 'Administration\NewsController');
// Resource for users
Route::resource('admin/users', 'Administration\UserController');
// Resource for News-Categories
Route::resource('admin/news-categories', 'Administration\NewsCategoriesController');
// Resource for settings
Route::resource('admin/settings', 'Administration\SettingsController');

Route::get('/', ['uses' => 'Homepage@index', 'as' => 'home']);

Route::get('/admin', ['middleware' => 'auth', 'uses' => 'Admin@index']);
Route::get('/admin/navigation', ['middleware' => 'auth', 'uses' => 'Admin@navigation']);
//Route::get('/admin/settings', ['middleware' => 'auth', 'uses' => 'Admin@settings']);
Route::get('/admin/languages', ['middleware' => 'auth', 'uses' => 'Admin@languages']);
Route::get('/admin/create_lang', ['middleware' => 'auth', 'uses' => 'Admin@create_lang']);

Route::post('/worker/do_create_language', ['middleware' => 'auth', 'uses' => 'Worker@do_create_language']);
Route::post('/worker/do_delete_language', ['middleware' => 'auth', 'uses' => 'Worker@do_delete_language']);
Route::post('/worker/do_navigation_change_order', ['middleware' => 'auth', 'uses' => 'Worker@do_navigation_change_order']);

/*Route::group(['middleware' => ['web']], function () {
	Route::auth();
});*/

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');
Route::post('/login/custom', [
	'uses' => 'LoginController@login',
	'as'   =>  'login.custom'
] );

$this->get('/login/logout', 'LoginController@logout');

// Password Reset Routes...
/*$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');*/


/**
 * {locale} - language = {en,sk}
 */
/*Route::get('/contact', ['uses' => 'Contact@index', 'as' => 'contact']);*/


/*Route::get('{lang}', ['uses' => 'Homepage@index', 'as' => 'en']);*/
Route::get('{slug}', ['uses' => 'Homepage@index', 'as' => 'page']);
Route::get('setlang/{lang}', 'Homepage@set_language');

Route::get('/home', 'HomeController@index');