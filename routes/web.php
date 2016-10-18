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
Route::get('/', 'Homepage@index');
/**
 * {locale} - language = {en,sk}
 */
Route::get('contact', 'Contact@index');
Route::get('{lang}', 'Homepage@index');
