<?php
$prefecture = $prefecturename; // コントローラーから渡された都道府県名
$places = $places;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $prefecture ?>のデートスポット一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'GenEiMGothic2-Bold';
            src: url('./font/GenEiMGothic2-Bold.ttf') format('truetype');
        }

        body {
            font-family: 'GenEiMGothic2-Bold', sans-serif;
        }

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
     {{-- ヘッダー呼び出し --}}
    @include('partials.header')
    <div class="container">
        <header class="my-4 text-center">
            <h1 class="display-4"><?= $prefecture ?>のデートスポット一覧</h1>
        </header>
        
        <main>
            <div class="row">
                <?php foreach ($places as $place): ?>
                <div class="col-12 mb-3">
                    <a href="<?= $place['link'] ?>" class="card-link"> <!-- # TODO -->
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
                                            <h2 class="card-title"><?= htmlspecialchars($place['name']) ?></h5>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-primary bg-color-blue text-white category-badge fs-6">#<?= htmlspecialchars($place['tag']) ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge rounded-pill bg-warning text-dark fs-4"><?= htmlspecialchars($place['rating']) ?></span>
                                            <small class="text-muted fs-6">(<?= number_format($place['countreviews']) ?>件の投稿)</small>
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
