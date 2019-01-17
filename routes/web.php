<?php

Route::get('/', 'Frontend\PageController@home')->name('home');
Route::get('/categories/{paginate?}', 'Frontend\PageController@categories')->name('categories');
Route::get('/category/{category}/{paginate?}', 'Frontend\PageController@category')->name('category');
Route::get('/article/{article}', 'Frontend\PageController@article')->name('article');

Route::get('/page/{slug}', ['as' => 'custom.page', 'uses' => 'Frontend\PageController@page']);
Route::get('/search', 'Backend\SearchController@basicSearch')->name('search.articles');
Route::post('/filter', 'Backend\SearchController@filter')->name('filter');

Route::post('comment-store', 'Frontend\CommentController@store')->name('comment.store');

Auth::routes();

Route::group(['prefix' => 'dashboard', 'namespace' => 'Backend'], function (){
    Route::get('/', 'AdminController@index')->name('dashboard');

    Route::resource('users', 'UserController');
    Route::resource('categories', 'CategoryController');
    Route::resource('articles', 'ArticleController');

    Route::post('/add-img', 'ArticleController@addImage')->name('articles.gallery.add.img');
    Route::post('/delete-img', 'ArticleController@deleteImage')->name('delete.image.in.gallery');

    Route::resource('pages', 'PageController');

    Route::get('comments', 'CommentController@index')->name('comments.index');
    Route::get('moderation-comments', 'CommentController@moderation')->name('comments.moderation');
    Route::get('comment-approve/{comment}', 'CommentController@approve')->name('comments.approve');
    Route::get('comment-delete/{comment}', 'CommentController@destroy')->name('comments.delete');
});

Route::group(['prefix' => 'account', 'namespace' => 'Backend'], function (){
    Route::get('/', 'AccountController@index')->name('account');
    Route::get('/my-article/{paginate?}', 'AccountController@listMyArticle')->name('my.article');
    Route::get('/my-favorite-article/{paginate?}', 'AccountController@listMyFavoriteArticle')->name('my.favorite.article');
    Route::get('/change-status-favorite/{article}', 'AccountController@changeStatusFavorite')->name('change.status.favorite.article');

    Route::resource('articles', 'AccountController', ['as' => 'blogger']);
});

