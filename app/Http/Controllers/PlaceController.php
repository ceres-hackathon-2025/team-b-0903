<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PlaceController extends Controller
{
    // 指定した場所の投稿おすすめ度の平均を返す
    public function recommendAverageByPlace($place_id)
    {
        $average = Post::where('place_id', $place_id)->avg('recommend');
        return response()->json(['recommend_average' => $average]);
    }

    // 指定したplaceの投稿数を返す
    public function postCount($place_id)
    {
        $count = Post::where('place_id', $place_id)->count();
        return response()->json(['post_count' => $count]);
    }

 
}
