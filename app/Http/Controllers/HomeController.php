<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prefecture;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        // 都道府県一覧を取得してhomeビューに渡す
    $prefectures = Prefecture::all();
    $posts = Post::all();
    return view('home', compact('prefectures', 'posts'));
    }
}
