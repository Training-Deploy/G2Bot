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

Route::get('/', 'Client\HomeController@index')->name('home');
Route::get('/auth', 'Client\HomeController@getAuth')->name('get.auth');
Route::get('login/email', 'Auth\LoginController@redirectToProvider')->name('login-client');
Route::get('login/email/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('login/submit', 'Auth\LoginController@login')->name('login');

Route::get('/logout', function () {
    Auth::logout();

    return redirect()->route('home');
})->name('logout-client');


Route::group(['prefix' => '/', 'namespace' => 'Client'], function () {
    Route::resource('bots', 'BotController', ['except' => ['create', 'edit', 'destroy']]);
    Route::resource('members', 'MemberController', ['except' => ['create', 'edit']]);
    Route::resource('rooms', 'RoomController', ['except' => ['create', 'edit']]);
    Route::get('rooms/fetch/{api}', 'RoomController@fetchRooms');
    Route::post('members/multipledelete', 'MemberController@multipleDestroy');
});
