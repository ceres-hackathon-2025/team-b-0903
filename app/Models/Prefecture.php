<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    // テーブル名
    protected $table = 'prefectures';

    // 複数代入可能な属性
    protected $fillable = [
        'name',
    ];
}
