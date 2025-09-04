<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prefecture;
use App\Models\Place;

class PlaceController extends Controller
{
    // 都道府県ごとの観光地一覧
    public function indexByPrefecture($prefecture)
    {
        $prefectureModel = Prefecture::where('id', $prefecture)->orWhere('name', $prefecture)->firstOrFail();
        $places = Place::where('prefecture_id', $prefectureModel->id)->get();
        return view('places', compact('places', 'prefectureModel'));
    }

}
