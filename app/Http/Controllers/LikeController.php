<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();

        // likes テーブルにいいねがあるか確認
        $exists = DB::table('likes')
            ->where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            // いいね取り消し
            DB::table('likes')
                ->where('post_id', $post->id)
                ->where('user_id', $user->id)
                ->delete();
        } else {
            // いいね追加
            DB::table('likes')->insert([
                'post_id' => $post->id,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // いいね数をカウント
        $likeCount = DB::table('likes')
            ->where('post_id', $post->id)
            ->count();

        return response()->json([
            'liked' => !$exists,      // 今回の状態（trueならいいねした）
            'like_count' => $likeCount,
        ]);
    }
}
