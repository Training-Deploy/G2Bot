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
    return view('clients.master');
})->name('home');

Route::get('login/email', 'Auth\LoginController@redirectToProvider')->name('login-client');
Route::get('login/email/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/logout', function () {
   Auth::logout();

   return redirect()->route('home');
})->name('logout-client');
