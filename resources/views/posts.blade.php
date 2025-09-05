@extends('layouts.app')

@section('content')
<div class="container">
    <h1>投稿一覧</h1>
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($post->image_path)
                        <img src="{{ asset('img/' . $post->image_path) }}" class="card-img-top" alt="投稿画像">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->body }}</p>
                        <p class="card-text"><small class="text-muted">{{ $post->created_at }}</small></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
<?php
$name = '東大寺';
$img_id = './img/test01.jpg';
$average_rating = 4.2;
$total_reviews = 247;

$reviews = [
    [
        'title' => '最高のサービスでした！',
        'rating' => '★★★★★',
        'content' => 'スタッフの対応が非常に丁寧で、料理も美味しく大満足でした。また利用したいと思います。特にパスタが絶品でした！',
        'author' => '田中太郎さん',
        'date' => '2024年3月15日',
        'image' => './img/test02.jpg',
        'count_favorites' => 34,
        'user_like' => false
    ],
    [
        'title' => '雰囲気が良くてデートにおすすめ',
        'rating' => '★★★★☆',
        'content' => '落ち着いた雰囲気で、カップルでの利用にぴったりでした。少し価格は高めですが、その分サービスと料理の質は良かったです。',
        'author' => '佐藤花子さん',
        'date' => '2024年3月12日',
        'image' => './img/test03.jpg'
        , 'count_favorites' => 21
        , 'user_like' => false
    ],
    [
        'title' => '家族連れにも安心',
        'rating' => '★★★★★',
        'content' => '子供連れで訪問しましたが、キッズメニューも充実していて、子供も大喜びでした。スタッフの方も子供に優しく対応してくれました。',
        'author' => '鈴木一郎さん',
        'date' => '2024年3月10日',
        'image' => './img/test04.jpg'
        , 'count_favorites' => 15
        , 'user_like' => false
    ],
    [
        'title' => 'コスパが良い！',
        'rating' => '★★★☆☆',
        'content' => '価格の割には量も多く、味も普通に美味しかったです。特別感はありませんが、日常使いには十分だと思います。',
        'author' => '山田次郎さん',
        'date' => '2024年3月8日',
        'image' => './img/test05.jpg'
        , 'count_favorites' => 8
        , 'user_like' => false
    ]
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($name) ?> - レビュー</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.header')
    <div class="container">
        <!-- 大きな見出し - 上部中央 -->
        <header class="text-center my-4">
            <h1 class="display-3"><?= htmlspecialchars($name) ?></h1>
        </header>
        
        <main>
            <div class="row">
                <!-- 左側：画像と口コミ一覧（全体の2/3） -->
                <div class="col-md-8">
                    <!-- 画像 -->
                    <div class="mb-4">
                        <img src="<?= htmlspecialchars($img_id) ?>" 
                             class="img-fluid w-100 rounded" 
                             style="height: 700px; object-fit: cover;" 
                             alt="<?= htmlspecialchars($name) ?>">
                    </div>
                    
                    <!-- 口コミ一覧 -->
                    <section>
                        <h2 class="h4 mb-3">投稿一覧</h2>
                        <?php foreach ($reviews as $review): ?>
                        <article class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h2 class="card-title h5"><?= htmlspecialchars($review['title']) ?></h2>
                                    <div class="text-warning">
                                        <?= htmlspecialchars($review['rating']) ?>
                                    </div>
                                </div>
                                <!-- 画像を上に配置 -->
                                <div class="mb-3">
                                    <img src="<?= htmlspecialchars($review['image']) ?>" 
                                         class="img-fluid rounded w-100" 
                                         style="height: 200px; object-fit: cover;" 
                                         alt="レビュー画像">
                                </div>
                                <!-- レビュー内容を下に配置 -->
                                <p class="card-text"><?= htmlspecialchars($review['content']) ?></p>
                                    <!-- ハート形ボタンとお気に入り数 -->
                                    <div class="d-flex align-items-center mb-2">
                                            <button class="btn btn-sm me-2 like-btn" 
                                                    style="border-radius:50%; padding:0; width:32px; height:32px;"
                                                    data-liked="<?= $review['user_like'] ? 'true' : 'false' ?>"
                                                    data-count="<?= $review['count_favorites'] ?>">
                                                <img src="<?= $review['user_like'] ? '/images/heart_red.png' : '/images/heart_white.png' ?>" 
                                                     alt="いいね" 
                                                     style="width:32px; height:32px; object-fit:contain;">
                                            </button>
                                        <span class="text-muted fs-6">いいね <span class="like-count"><?= htmlspecialchars($review['count_favorites']) ?></span></span>
                                    </div>
                                <footer class="text-muted d-flex justify-content-between mt-2">
                                    <small>投稿者: <?= htmlspecialchars($review['author']) ?></small>
                                    <small>投稿日: <?= htmlspecialchars($review['date']) ?></small>
                                </footer>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </section>
                </div>
                
                <!-- 右側：レビュー統計（全体の1/3） -->
                <aside class="col-md-4">
                    <!-- レビュー平均値を大きく表示 -->
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <div class="display-4 text-warning mb-2">
                                ★<?= number_format($average_rating, 1) ?>
                            </div>
                            <h3 class="h5 mb-1">平均評価</h3>
                            <p class="text-muted mb-3"><?= $total_reviews ?>件のレビュー</p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3>口コミを投稿</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm">レビューを書く</button>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
        
        <footer class="mt-5 text-center">
            <p>&copy; 2024 <?= htmlspecialchars($name) ?> Reviews</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/favo.js"></script>
</body>
</html>
