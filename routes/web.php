<?php

use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PostController;

// ホーム画面
Route::get('/', [HomeController::class, 'index'])->name('home');

// 投稿一覧
Route::get('/posts', function () {
    return view('posts');
});


// 都道府県ごとの観光地一覧
Route::get('/prefectures/{prefecture}', [PlaceController::class, 'indexByPrefecture'])->name('places.byPrefecture');

// 観光地ごとの投稿一覧
Route::get('/places/{place}', [PostController::class, 'indexByPlace'])->name('posts.byPlaceWithPrefecture');

// 投稿作成フォーム
Route::get('/{place}/create', function ($place) {
    return view('create', ['place_id' => $place]);
});

//投稿詳細
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.showByPlace');


// 投稿詳細から投稿者だけが投稿編集
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('can:update,post')->name('posts.edit');







// タグごとの投稿一覧
//Route::get('/tags/{tag}/posts', [PostController::class, 'indexByTag'])->name('posts.byTag');

// タグ経由で観光地ごとの投稿一覧
//Route::get('/tags/{tag}/places/{place}', [PostController::class, 'indexByPlaceWithTag'])->name('posts.byPlaceWithTag');



