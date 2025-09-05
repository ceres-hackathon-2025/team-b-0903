<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->truncate();
            $reviews = [
                [
                    'title' => '圧巻の大仏様と、鹿との触れ合いに癒されました！',
                    'content' => 'ずっと行きたかった東大寺に、彼と二人で念願の訪問！大仏様の大きさに圧倒され、二人で「すごいね！」と感動しっぱなしでした。広大な境内にはたくさんの鹿がいて、鹿せんべいをあげると近寄ってきてくれて、とても可愛かったです。お互いの写真をたくさん撮りあって、素敵な思い出ができました。歴史を感じる荘厳な雰囲気と、可愛い鹿たちに癒される、最高のデートスポットです！',
                    'like_count' => 85,
                    'recommend' => 5,
                    'img_path' => 'img/posts/dummy_todaiji0001.jpg',
                ],
                [
                    'title' => '雰囲気が良くてデートにおすすめ',
                    'content' => '落ち着いた雰囲気で、カップルでの利用にぴったりでした。少し価格は高めですが、その分サービスと料理の質は良かったです。',
                    'like_count' => 21,
                    'recommend' => 5,
                    'img_path' => 'img/posts/dummy_todaiji0002.jpg',
                ],
                [
                    'title' => '家族連れにも安心',
                    'content' => '子供連れで訪問しましたが、キッズメニューも充実していて、子供も大喜びでした。スタッフの方も子供に優しく対応してくれました。',
                    'like_count' => 15,
                    'recommend' => 4,
                    'img_path' => 'img/posts/dummy_todaiji0003.jpg',
                ],
                [
                    'title' => 'コスパが良い！',
                    'content' => '価格の割には量も多く、味も普通に美味しかったです。特別感はありませんが、日常使いには十分だと思います。',
                    'like_count' => 8,
                    'recommend' => 4,
                    'img_path' => 'img/posts/dummy_todaiji0004.jpg',
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
