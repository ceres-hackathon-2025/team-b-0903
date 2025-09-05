<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
            $reviews = [
                [
                    'title' => '最高のサービスでした！',
                    'content' => 'スタッフの対応が非常に丁寧で、料理も美味しく大満足でした。また利用したいと思います。特にパスタが絶品でした！',
                    'like_count' => 34,
                    'recommend' => 5,
                    'img_path' => 'images/review02.jpg',
                ],
                [
                    'title' => '雰囲気が良くてデートにおすすめ',
                    'content' => '落ち着いた雰囲気で、カップルでの利用にぴったりでした。少し価格は高めですが、その分サービスと料理の質は良かったです。',
                    'like_count' => 21,
                    'recommend' => 5,
                    'img_path' => 'images/review03.jpg',
                ],
                [
                    'title' => '家族連れにも安心',
                    'content' => '子供連れで訪問しましたが、キッズメニューも充実していて、子供も大喜びでした。スタッフの方も子供に優しく対応してくれました。',
                    'like_count' => 15,
                    'recommend' => 4,
                    'img_path' => 'images/review04.jpg',
                ],
                [
                    'title' => 'コスパが良い！',
                    'content' => '価格の割には量も多く、味も普通に美味しかったです。特別感はありませんが、日常使いには十分だと思います。',
                    'like_count' => 8,
                    'recommend' => 4,
                    'img_path' => 'images/review05.jpg',
                ]
            ];

            foreach ($reviews as $review) {
                DB::table('posts')->insert([
                    'user_id' => 1,
                    'place_id' => 1,
                    'title' => $review['title'],
                    'content' => $review['content'],
                    'recommend' => $review['recommend'],
                    'like_count' => $review['like_count'],
                    'img_path' => $review['img_path'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    }
}
