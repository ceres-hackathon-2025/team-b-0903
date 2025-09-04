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
        'image' => './img/test02.jpg'
    ],
    [
        'title' => '雰囲気が良くてデートにおすすめ',
        'rating' => '★★★★☆',
        'content' => '落ち着いた雰囲気で、カップルでの利用にぴったりでした。少し価格は高めですが、その分サービスと料理の質は良かったです。',
        'author' => '佐藤花子さん',
        'date' => '2024年3月12日',
        'image' => './img/test03.jpg'
    ],
    [
        'title' => '家族連れにも安心',
        'rating' => '★★★★★',
        'content' => '子供連れで訪問しましたが、キッズメニューも充実していて、子供も大喜びでした。スタッフの方も子供に優しく対応してくれました。',
        'author' => '鈴木一郎さん',
        'date' => '2024年3月10日',
        'image' => './img/test04.jpg'
    ],
    [
        'title' => 'コスパが良い！',
        'rating' => '★★★☆☆',
        'content' => '価格の割には量も多く、味も普通に美味しかったです。特別感はありませんが、日常使いには十分だと思います。',
        'author' => '山田次郎さん',
        'date' => '2024年3月8日',
        'image' => './img/test05.jpg'
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
</body>
</html>
