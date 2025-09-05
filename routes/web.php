<?php
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
require __DIR__.'/auth.php';

// 口コミ作成画面
Route::get('/create/{place_id}', [PostController::class, "create"] )->name('posts.create');
Route::post('/show', [PostController::class, "store"] )->name('posts.store');

// 場所一覧
Route::get('/places', function () {
    return view('places');
});

// ホーム画面
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');


// 投稿詳細から投稿者だけが投稿編集
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
// 投稿更新（編集フォーム送信）
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');




// タグごとの投稿一覧
//Route::get('/tags/{tag}/posts', [PostController::class, 'indexByTag'])->name('posts.byTag');

// タグ経由で観光地ごとの投稿一覧
//Route::get('/tags/{tag}/places/{place}', [PostController::class, 'indexByPlaceWithTag'])->name('posts.byPlaceWithTag');


