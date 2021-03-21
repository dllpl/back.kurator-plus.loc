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
//    return view('welcome');
    return redirect(route('login'));
});

Auth::routes(['verify' => true]);

// for debug purposes on local environment
Route::get('/home', 'HomeController@index')->name('home');

// check that a user has verified email
//Route::getRoutes()->getByName('passport.authorizations.authorize')->middleware('verified');

// for simple logout using get method
Route::get('logout', 'Auth\LoginController@logout');

// social networks login routes
Route::prefix('login/{driver}')->group(function () {
    Route::get('/', 'Auth\LoginController@redirectToProvider')->name('provider.login');
    Route::get('callback', 'Auth\LoginController@handleProviderCallback')->name('provider.callback');
});

