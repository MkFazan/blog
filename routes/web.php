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

Route::get('/', 'Frontend\PageController@home')->name('home');

Auth::routes();

Route::get('/account', 'Backend\AccountController@index')->name('account');

Route::group(['prefix' => 'dashboard', 'namespace' => 'Backend'], function (){
    Route::get('/', 'AdminController@index')->name('dashboard');

    Route::resource('users', 'UserController');
});

