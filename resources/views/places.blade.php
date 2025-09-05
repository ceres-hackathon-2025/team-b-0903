<?php
$prefecture = $prefecturename; // コントローラーから渡された都道府県名
$places = $places;
$img_id = "01"; // TODO
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $prefecture ?>のデートスポット一覧</title>
    <style>
        :root{
            --base-rgb: 234,206,202;
            --base: rgb(var(--base-rgb));
            --base-strong: rgb(199,149,141);
            --ink:#2b2726; --muted:#6b6462; --paper:#fff;
            --ring: rgba(var(--base-rgb), .55);
            --maxw: 1100px; --radius: 16px;
        }
        body{ 
            margin:0; 
            color:var(--ink); 
            font-family:system-ui,-apple-system,Segoe UI,Roboto,"Noto Sans JP",sans-serif; 
            background:#fffdfa; 
        }

        /* コンテナ */
        .container{ max-width:var(--maxw); margin:0 auto; padding: 1rem; }

        /* ヘッダー */
        .page-header{
            text-align: center;
            margin: 1.5rem 0 2rem;
        }
        .page-title{
            font-size: 2rem;
            font-weight: 800;
            color: var(--ink);
            margin: 0;
        }

        /* カードグリッド - 中央寄せで幅を制限 */
        .places-grid{
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            max-width: 800px;
            margin: 0 auto;
        }

        /* カード */
        .place-card{
            border: 1px solid rgba(0,0,0,.08);
            border-radius: var(--radius);
            background: #fff;
            box-shadow: 0 10px 28px rgba(0,0,0,.06);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .place-card:hover{
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,.12);
            text-decoration: none;
            color: inherit;
        }

        .card-content{
            display: flex;
            align-items: stretch;
        }

        /* 画像部分 */
        .image-section{
            flex: 0 0 280px;
            position: relative;
        }
        .place-image{
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center;
        }

        /* テキスト部分 */
        .content-section{
            flex: 1;
            padding: 1.2rem 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .place-title{
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0 0 0.8rem;
            color: var(--ink);
        }

        .place-rating{
            display: inline-block;
            background: linear-gradient(135deg, #ffd700, #ffb300);
            color: #333;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* レスポンシブ */
        @media (max-width: 768px){
            .card-content{
                flex-direction: column;
            }
            .image-section{
                flex: none;
            }
            .place-image{
                height: 180px;
            }
            .content-section{
                padding: 1rem;
            }
            .page-title{
                font-size: 1.5rem;
            }
        }

        /* ページネーション */
        .pagination-wrapper{
            margin: 3rem 0 2rem;
            display: flex;
            justify-content: center;
        }
        .pagination{
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        .page-link{
            padding: 0.5rem 1rem;
            border: 1px solid rgba(var(--base-rgb), .55);
            background: rgba(var(--base-rgb), .22);
            color: #5a453f;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }
        .page-link:hover{
            background: var(--base);
            text-decoration: none;
            color: #5a453f;
        }
        .page-link.active{
            background: var(--base-strong);
            color: #fff;
        }
        .page-link.disabled{
            opacity: 0.5;
            pointer-events: none;
        }

        /* フッター */
        .footer{
            margin-top: 3rem;
            padding: 2rem 0;
            background: rgba(var(--base-rgb), .1);
            text-align: center;
            color: var(--muted);
        }
    </style>
</head>
<body>
     {{-- ヘッダー呼び出し --}}
    @include('partials.header')
    <div class="container">
        <header class="page-header">
            <h1 class="page-title"><?= $prefecture ?>のデートスポット一覧</h1>
        </header>
        
        <main>
            <div class="places-grid">
                <?php foreach ($places as $place): ?>
                    <a href="" class="place-card"> <!-- # TODO -->
                        <div class="card-content">
                            <div class="image-section">
                                <img src="{{ asset('img/test' . $img_id . '.jpg') }}" 
                                     class="place-image" 
                                     alt="<?= htmlspecialchars($place['name']) ?>">
                            </div>
                            <div class="content-section">
                                <div>
                                    <h2 class="place-title"><?= htmlspecialchars($place['name']) ?></h2>
                                </div>
                                <div>
                                    <span class="place-rating"><?= htmlspecialchars($place['recommend_average']) ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- <div class="pagination-wrapper">
                <nav>
                    <div class="pagination">
                        <span class="page-link disabled">前へ</span>
                        <span class="page-link active">1</span>
                        <a class="page-link" href="#">2</a>
                        <a class="page-link" href="#">3</a>
                        <a class="page-link" href="#">次へ</a>
                    </div>
                </nav>
            </div> -->
        </main>
        
        <!-- <footer class="footer">
            <p>&copy; 2024 奈良県観光ガイド. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>
