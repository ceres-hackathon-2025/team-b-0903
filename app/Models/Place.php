<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';
    protected $fillable = [
        'name',
        'prefectures_id',
        'recommend_average',
    ];

    // リレーション例: Prefecture
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class, 'prefectures_id');
    }
}
