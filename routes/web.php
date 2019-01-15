<?php

Route::get('/', 'Frontend\PageController@home')->name('home');

Auth::routes();

Route::get('/account', 'Backend\AccountController@index')->name('account');

Route::group(['prefix' => 'dashboard', 'namespace' => 'Backend'], function (){
    Route::get('/', 'AdminController@index')->name('dashboard');

    Route::resource('users', 'UserController');
    Route::resource('categories', 'CategoryController');
    Route::resource('articles', 'ArticleController');

    Route::post('/add-img', 'ArticleController@addImage')->name('articles.gallery.add.img');
    Route::post('/delete-img', 'ArticleController@deleteImage')->name('delete.image.in.gallery');

    Route::resource('pages', 'PageController');
});

