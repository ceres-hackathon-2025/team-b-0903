<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('places')->truncate();

        $nara_places = [
            '東大寺',
            '奈良公園',
            '春日大社',
            '薬師寺',
            '法隆寺',
            '興福寺',
            'ならまち',
            '飛鳥寺',
            '吉野山',
        ];

        $image_passes = [
            'img/toudaiji.jpg',
            'img/nara_park.jpg',
            'img/kasuga_taisha.jpg',
            'img/yakushiji.jpg',
            'img/horyuji.jpg',
            'img/kofukuji.jpg',
            'img/naramachi.jpg',
            'img/asukadera.jpg',
            'img/yoshinoyama.jpg',
        ];

        foreach ($nara_places as $index => $place_name) {
            DB::table('places')->insert([
                'name' => $place_name,
                'prefecture_id' => 29,              // 奈良県のID（注意：prefecturesのSeederでIDが変わるなら確認して）
                'recommend_average' => 3,          // 仮の平均値（必須なら）
                'image_pass' => $image_passes[$index], // 画像パスを追加
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
