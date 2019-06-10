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
    return view('index');
});

/*Auth::routes();

Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});

Route::match(['get', 'post'], 'password/reset', function(){
    return redirect('/');
});*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::resource('credits', 'CreditsController');
Route::get('credits/search', 'CreditsController@search');
