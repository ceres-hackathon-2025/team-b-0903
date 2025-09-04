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
        $prefecturename = Prefecture::select('name')->where('id', $prefecture)->firstOrFail();
        $places = Place::where('prefecture_id', $prefecture)->get();
        return view('places', compact('places', 'prefecturename'));
    }

}
