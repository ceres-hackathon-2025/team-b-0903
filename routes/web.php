<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 投稿作成フォーム
Route::get('/create', function () {
    return view('create');
});
