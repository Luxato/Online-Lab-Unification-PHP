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
/*Route::get( '/', 'Homepage@index' );*/
Route::get('/', ['uses' => 'Homepage@index', 'as' => 'home']);
/**
 * {locale} - language = {en,sk}
 */
/*Route::get( 'contact', [ 'as' => 'home' ], 'Contact@index' );*/
Route::get('contact', ['uses' => 'Contact@index', 'as' => 'contact']);
Route::get( '{lang}', 'Homepage@index' );
