<?php

Route::get('/', 'Frontend\PageController@home')->name('home');

Auth::routes();

Route::group(['prefix' => 'dashboard', 'namespace' => 'Backend'], function (){
    Route::get('/', 'AdminController@index')->name('dashboard');

    Route::resource('users', 'UserController');
    Route::resource('categories', 'CategoryController');
    Route::resource('articles', 'ArticleController');

    Route::post('/add-img', 'ArticleController@addImage')->name('articles.gallery.add.img');
    Route::post('/delete-img', 'ArticleController@deleteImage')->name('delete.image.in.gallery');

    Route::resource('pages', 'PageController');
});

Route::group(['prefix' => 'account', 'namespace' => 'Backend'], function (){
    Route::get('/', 'AccountController@index')->name('account');
    Route::get('/my-article/{paginate?}', 'AccountController@listMyArticle')->name('my.article');
    Route::get('/my-favorite-article/{paginate?}', 'AccountController@listMyFavoriteArticle')->name('my.favorite.article');

    Route::resource('articles', 'AccountController', ['as' => 'blogger']);
});

