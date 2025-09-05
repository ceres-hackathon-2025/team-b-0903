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
                    'img_path' => 'img/posts/dummy_todaiji_0001.jpg',
                ],
                [
                    'title' => '夕暮れの参道も素敵。静かに過ごしたいカップルにおすすめ！',
                    'content' => 'お昼過ぎから東大寺を散策しました。大仏殿は何度見ても迫力満点です。夕暮れ時になると参拝客も減り、ゆっくりと散策できました。彼と二人で夕日に照らされる五重塔を見ながら、静かな時間を過ごせたのがとてもよかったです。人混みを避け、落ち着いて東大寺の雰囲気を楽しみたいカップルには、夕方から訪れるのがおすすめです。',
                    'like_count' => 42,
                    'recommend' => 4,
                    'img_path' => 'img/posts/dummy_todaiji_0002.jpg',
                ],
                [
                    'title' => '紅葉の時期は最高！ただ、人が多いので注意が必要',
                    'content' => '紅葉の時期に合わせて東大寺を訪れました。境内一面に広がる紅葉は息をのむほど美しく、彼女も私も大満足！大仏殿と紅葉のコントラストが本当に素晴らしかったです。ただ、想像以上に観光客が多く、特に大仏殿の中はかなり混雑していました。写真を撮るのも一苦労だったので、人が少ない平日や早朝を狙うのが良いかもしれません。',
                    'like_count' => 155,
                    'recommend' => 3,
                    'img_path' => 'img/posts/dummy_todaiji_0003.jpg',
                ],
                [
                    'title' => '初めての奈良旅行に！歩きやすい靴が必須です',
                    'content' => '初めての奈良旅行で東大寺を訪れました。大仏様のスケールの大きさに感動！参道から大仏殿まで、歩く距離がけっこうあるので、歩きやすいスニーカーを履いてきて正解でした。彼女はヒールを履いてきたので少し大変そうでした。鹿との写真撮影も楽しかったですが、かばんに入っている食べ物を狙ってくるので、荷物はしっかり持ったほうがいいです。',
                    'like_count' => 68,
                    'recommend' => 4,
                    'img_path' => 'img/posts/dummy_todaiji_0004.jpg',
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
