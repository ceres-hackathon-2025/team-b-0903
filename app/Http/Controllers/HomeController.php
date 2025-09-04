<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prefecture;
use App\Models\Place;

class HomeController extends Controller
{
    public function index()
    {
        // 都道府県一覧を取得してhomeビューに渡す
        $prefectures = Prefecture::all();
        $places = Place::all();
        return view('home', compact('prefectures', 'places'));
    }
}
