<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PlaceController extends Controller
{
    // 指定したplaceの投稿数を返す
    public function postCount($place_id)
    {
        $count = Post::where('place_id', $place_id)->count();
        return response()->json(['post_count' => $count]);
    }

    // 全投稿のおすすめ度の平均を返す
    public function recommendAverage()
    {
        $average = Post::avg('recommend');
        return response()->json(['recommend_average' => $average]);
    }
}
