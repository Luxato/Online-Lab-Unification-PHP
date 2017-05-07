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
Route::post( 'admin/page_create/', 'Admin@do_page_create' );

// Resource for pages
Route::resource( 'admin/pages', 'Administration\PageController' );
// Resource for news
Route::resource( 'admin/actualities', 'Administration\ActualitiesController' );
// Resource for users
Route::resource( 'admin/users', 'Administration\UserController' );
// Resource for News-Categories
Route::resource( 'admin/news-categories', 'Administration\NewsCategoriesController' );
// Resource for settings
Route::get( '/admin/settings', [ 'uses' => 'Administration\SettingsController@index' ] );
Route::post( 'admin/settings/', 'Administration\SettingsController@update' );
// Resource for languages
Route::resource( 'admin/languages', 'Administration\LanguageController' );

// FRONT reources
// Resource for users
Route::resource( 'users', 'UserController' );
// Resource for api
Route::match( [ 'get', 'post' ], '/api/{apiname}', 'ApiController@index' );

Route::get( '/admin/create_lang', [ 'middleware' => 'auth', 'uses' => 'Admin@create_lang' ] );

Route::get( '/', [ 'uses' => 'Homepage@index', 'as' => 'home' ] );

Route::get( '/admin', [ 'middleware' => 'auth', 'uses' => 'Admin@index' ] );
Route::get( '/admin/navigation-reorder', 'Administration\PageController@reorder' );

Route::post( '/worker/do_create_language', [ 'middleware' => 'auth', 'uses' => 'Worker@do_create_language' ] );

Route::post( '/worker/do_navigation_change_order', [
	'middleware' => 'auth',
	'uses'       => 'Worker@do_navigation_change_order'
] );

/*Route::group(['middleware' => ['web']], function () {
});*/

// Administration authentication Routes...
$this->get( 'login', 'Auth\LoginController@showLoginForm' )->name( 'login' );
$this->post( 'login', 'Auth\LoginController@login' );
$this->post( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );

// User authentification Routes...
$this->get( 'register', 'Auth\RegisterController@showRegistrationForm' )->name( 'register' );
$this->post( 'register', 'Auth\RegisterController@register' );
Route::post( '/login/custom', [
	'uses' => 'LoginController@login',
	'as'   => 'login.custom'
] );
Route::post( '/login/ldap', [
	'uses' => 'LoginController@login_ldap'
] );
$this->get( '/login/logout', 'LoginController@logout' );

Route::get( 'aktualita/{slug}', [ 'uses' => 'Homepage@aktuality' ] );
Route::get( '{slug}', 'Homepage@index' );
Route::get( 'setlang/{lang}', 'Homepage@set_language' );