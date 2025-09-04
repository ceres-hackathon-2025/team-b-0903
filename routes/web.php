<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 投稿(Post)のルーティング
Route::prefix('posts')->group(function () {
    // 投稿一覧
    Route::get('/posts', 'App\\Http\\Controllers\\PostController@index')->name('posts.index');
    // 投稿作成フォーム
    Route::get('/create', 'App\\Http\\Controllers\\PostController@create')->name('posts.create');
    // 投稿保存
    Route::post('/create', 'App\\Http\\Controllers\\PostController@store')->name('posts.store');
    // 投稿詳細
    Route::get('/posts/{post}', 'App\\Http\\Controllers\\PostController@show')->name('posts.show');
    // 投稿編集フォーム
    Route::get('/posts/{post}/edit', 'App\\Http\\Controllers\\PostController@edit')->name('posts.edit');
    // 投稿更新
    Route::put('/posts/{post}', 'App\\Http\\Controllers\\PostController@update')->name('posts.update');
    // 投稿削除
    Route::delete('/posts/{post}', 'App\\Http\\Controllers\\PostController@destroy')->name('posts.destroy');
});
