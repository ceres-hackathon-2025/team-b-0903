<?php
$places = [
    [
        'name' => '東大寺',
        'category' => '世界遺産',
        'category_class' => 'bg-warning',
        'description' => '奈良の大仏で有名な華厳宗大本山。743年に聖武天皇の発願で建立された歴史ある寺院です。',
        'address' => '奈良市雑司町406-1',
        'rating' => '★★★★★ (4.8)',
        'image_id' => '01',
        'link' => '#'
    ],
    [
        'name' => '奈良公園',
        'category' => '公園',
        'category_class' => 'bg-success',
        'description' => '約1200頭の鹿が自由に暮らす広大な公園。春日大社、東大寺、興福寺などの史跡も含まれています。',
        'address' => '奈良市雑司町・春日野町他',
        'rating' => '★★★★☆ (4.6)',
        'image_id' => '02',
        'link' => '#'
    ],
    [
        'name' => '春日大社',
        'category' => '神社',
        'category_class' => 'bg-info',
        'description' => '全国に約1000社ある春日神社の総本社。約3000基の石灯籠と吊灯籠で有名な古社です。',
        'address' => '奈良市春日野町160',
        'rating' => '★★★★☆ (4.7)',
        'image_id' => '03',
        'link' => '#'
    ],
    [
        'name' => '興福寺',
        'category' => '世界遺産',
        'category_class' => 'bg-warning',
        'description' => '藤原氏の氏寺として栄えた法相宗大本山。五重塔は奈良のシンボルとして親しまれています。',
        'address' => '奈良市登大路町48',
        'rating' => '★★★★☆ (4.5)',
        'image_id' => '04',
        'link' => '#'
    ],
    [
        'name' => '法隆寺',
        'category' => '世界遺産',
        'category_class' => 'bg-warning',
        'description' => '聖徳太子ゆかりの寺院で、現存する世界最古の木造建築群。日本初の世界文化遺産に登録されました。',
        'address' => '生駒郡斑鳩町法隆寺山内1-1',
        'rating' => '★★★★★ (4.9)',
        'image_id' => '05',
        'link' => '#'
    ],
    [
        'name' => '唐招提寺',
        'category' => '寺院',
        'category_class' => 'bg-secondary',
        'description' => '鑑真和上が創建した律宗総本山。金堂は天平建築の傑作として国宝に指定されています。',
        'address' => '奈良市五条町13-46',
        'rating' => '★★★★☆ (4.4)',
        'image_id' => '06',
        'link' => '#'
    ]
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>奈良県の史跡・観光地</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .place-card {
            transition: transform 0.2s;
            cursor: pointer;
        }
        .place-card:hover {
            transform: translateY(-5px);
        }
        .category-badge {
            font-size: 0.75rem;
        }
        .card-link {
            text-decoration: none;
            color: inherit;
        }
        .card-link:hover {
            color: inherit;
            text-decoration: none;
        }
        .place-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            object-position: center;
            border-radius: 0.375rem 0 0 0.375rem;
        }
        .image-container {
            height: 250px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="my-4 text-center">
            <h1 class="display-4">場所一覧</h1>
        </header>
        
        <main>
            <div class="row">
                <?php foreach ($places as $place): ?>
                <div class="col-12 mb-3">
                    <a href="<?= $place['link'] ?>" class="card-link">
                        <div class="card place-card">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <div class="image-container">
                                        <img src="./img/test<?= $place['image_id'] ?>.jpg" 
                                             class="place-image" 
                                             alt="<?= htmlspecialchars($place['name']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title"><?= htmlspecialchars($place['name']) ?></h5>
                                            <span class="badge <?= $place['category_class'] ?> category-badge"><?= htmlspecialchars($place['category']) ?></span>
                                        </div>
                                        <p class="card-text"><?= htmlspecialchars($place['description']) ?></p>
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($place['address']) ?>
                                            </small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-warning"><?= htmlspecialchars($place['rating']) ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <span class="page-link">前へ</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">次へ</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </main>
        
        <footer class="mt-5 py-4 bg-light text-center">
            <p>&copy; 2024 奈良県観光ガイド. All rights reserved.</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
