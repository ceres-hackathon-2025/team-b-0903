<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    // リレーション例: Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // リレーション例: User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
