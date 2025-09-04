<?php
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// 投稿作成フォーム
// Route::get('/create/{place_id}', function () {
//     return view('create');
// });
Route::get('/create/{place_id}', [PostController::class, "create"] )->name('posts.create');
Route::post('/', [PostController::class, "store"] )->name('posts.store');

// 場所一覧
Route::get('/places', function () {
    return view('places');
});

// ホーム画面
Route::get('/', function () {
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
