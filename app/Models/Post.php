<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'place_id',
        'title',
        'content',
        'recommend',
        'like_count',
    ];

    // リレーション例: Place
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    // リレーション例: User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
