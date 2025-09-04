<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 投稿作成フォーム
Route::get('/creat', function () {
    return view('creat');
});

// // 投稿(Post)のルーティング
// Route::prefix('posts')->group(function () {
//     // 投稿一覧
//     Route::get('/posts', 'App\\Http\\Controllers\\PostController@index')->name('posts.index');
//     // 投稿作成フォーム
//     Route::get('/create', 'App\\Http\\Controllers\\PostController@create')->name('posts.create');
//     // 投稿保存
//     Route::post('/create', 'App\\Http\\Controllers\\PostController@store')->name('posts.store');
//     // 投稿詳細
//     Route::get('/posts/{post}', 'App\\Http\\Controllers\\PostController@show')->name('posts.show');
//     // 投稿編集フォーム
//     Route::get('/posts/{post}/edit', 'App\\Http\\Controllers\\PostController@edit')->name('posts.edit');
//     // 投稿更新
//     Route::put('/posts/{post}', 'App\\Http\\Controllers\\PostController@update')->name('posts.update');
//     // 投稿削除
//     Route::delete('/posts/{post}', 'App\\Http\\Controllers\\PostController@destroy')->name('posts.destroy');
// });

Route::get('/create', function () {
    return view('create');
});

Route::get('/post', function () {
    return view('create');
});



use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// …既存のルートの下あたりに追加
Route::get('/api/places', function(Request $request) {
    $q = (string) $request->query('q', '');
    $limit = min((int)$request->query('limit', 20), 50);

    $query = DB::table('places')->select('id', 'name');

    if ($q !== '') {
        // 先頭一致。「い」で始まるスポット → 'い%'
        $query->where('name', 'like', $q.'%');
        // （必要ならカタカナや半角全角の正規化を追加）
    }

    return response()->json($query->orderBy('name')->limit($limit)->get());
})->name('api.places');
