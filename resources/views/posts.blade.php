<?php
function renderStars($score) {
    $full = floor($score);
    $half = ($score - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
    return str_repeat('★', $full) . ($half ? '☆' : '') . str_repeat('☆', $empty);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($place_name) ?> - レビュー</title>

    <style>
        :root{
            --base-rgb: 234,206,202;
            --base: rgb(var(--base-rgb));
            --base-strong: rgb(199,149,141);
            --ink:#2b2726; --muted:#6b6462; --paper:#fff;
            --ring: rgba(var(--base-rgb), .55);
            --maxw: 1100px; --radius: 16px;
        }
        body{ margin:0; color:var(--ink); font-family:system-ui,-apple-system,Segoe UI,Roboto,"Noto Sans JP",sans-serif; background:#fffdfa; }

        /* コンテナ */
        .container{ max-width:var(--maxw); margin:0 auto; padding: 1rem; }

        /* セクション */
        .section{ margin: 1.5rem 0 2.2rem; }
        .h2{ display:flex; align-items:center; gap:.6rem; margin:0 0 .8rem; font-size:1.1rem; }
        .grid{ display:grid; gap:1rem; }
        @media (min-width:720px){ .grid.cols-3{ grid-template-columns: repeat(3,1fr); } }
        .card{ border:1px solid rgba(0,0,0,.08); border-radius:16px; background:#fff; box-shadow: 0 10px 28px rgba(0,0,0,.06); overflow:hidden }
        .card .ph{ aspect-ratio: 16/9; background:linear-gradient(135deg,#ffe6e1,#ffd1ca); display:flex; align-items:center; justify-content:center; color:#b07164; font-weight:900 }
        .card .bd{ padding:.8rem .9rem 1rem }
        .card .tt{ margin:.1rem 0 .35rem; font-weight:800 }
        .card .meta{ color:var(--muted); font-size:.85rem }
        .tag{ display:inline-block; margin:.25rem .35rem 0 0; font-size:.72rem; color:#5a453f; background:rgba(var(--base-rgb), .22); border:1px solid rgba(var(--base-rgb), .55); padding:.08rem .5rem; border-radius:999px }
        .sep{ height:1px; background:linear-gradient(90deg, transparent, rgba(0,0,0,.08), transparent); margin: 1.2rem 0 1.5rem; }

        /* ページタイトル */
        .page-title{ text-align: center; margin: 2rem 0; font-size: 2.5rem; font-weight: 800; }

        /* メインコンテンツ中央寄せ */
        .main-content{ max-width: 900px; margin: 0 auto; }

        /* 画像と評価セクション */
        .hero-section{ display: flex; gap: 2rem; margin-bottom: 3rem; }
        .place-image{ flex: 2; }
        .place-image img{ width: 100%; height: 400px; object-fit: cover; border-radius: var(--radius); }
        .place-info{ flex: 1; display: flex; flex-direction: column; gap: 1rem; }
        
        /* 評価カード */
        .rating-card{ 
            background: #fff; 
            border: 1px solid rgba(0,0,0,.08); 
            border-radius: var(--radius); 
            padding: 1.5rem; 
            text-align: center; 
            box-shadow: 0 10px 28px rgba(0,0,0,.06); 
        }
        .rating-score{ font-size: 3rem; color: #ffc107; font-weight: 800; margin-bottom: 0.5rem; }
        .rating-label{ font-size: 1.1rem; font-weight: 600; color: var(--ink); }

        /* 投稿ボタンカード */
        .post-action-card{ 
            background: #fff; 
            border: 1px solid rgba(0,0,0,.08); 
            border-radius: var(--radius); 
            padding: 1.5rem; 
            text-align: center; 
            box-shadow: 0 10px 28px rgba(0,0,0,.06); 
        }
        .post-btn{ 
            appearance: none; 
            border: 0; 
            cursor: pointer; 
            padding: 1rem 2rem; 
            border-radius: 12px; 
            font-weight: 800; 
            color: #fff; 
            background: linear-gradient(180deg, var(--base), var(--base-strong)); 
            box-shadow: 0 8px 20px rgba(var(--base-rgb), .45); 
        }

        /* 投稿一覧 */
        .posts-section{ margin-top: 3rem; }
        .post-item{ 
            background: #fff; 
            border: 1px solid rgba(0,0,0,.08); 
            border-radius: var(--radius); 
            padding: 1.5rem; 
            margin-bottom: 1.5rem; 
            box-shadow: 0 10px 28px rgba(0,0,0,.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .post-item:hover{ 
            transform: translateY(-2px); 
            box-shadow: 0 15px 35px rgba(0,0,0,.12);
        }
        .post-header{ display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; }
        .post-title{ font-size: 1.2rem; font-weight: 800; margin: 0; }
        .post-rating{ color: #ffc107; font-weight: 600; }
        .post-image{ width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem; }
        .post-content{ margin-bottom: 1rem; line-height: 1.6; }
        .post-clickable-area{
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .post-clickable-area:hover{ 
            text-decoration: none;
            color: inherit;
        }
        .post-actions{ display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
        .like-btn{ 
            background: none; 
            border: none; 
            cursor: pointer; 
            padding: 0; 
            border-radius: 50%; 
            width: 32px; 
            height: 32px; 
        }
        .post-meta{ display: flex; justify-content: space-between; color: var(--muted); font-size: 0.9rem; }

        /* レスポンシブ */
        @media (max-width: 768px) {
            .hero-section{ flex-direction: column; gap: 1rem; }
            .place-image img{ height: 250px; }
            .page-title{ font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    @include('partials.header')
    
    <div class="container">
        <!-- ページタイトル -->
        <header class="page-title">
            <h1>{{ $place_name }}</h1>
        </header>
        
        <div class="main-content">
            <!-- 画像と評価セクション -->
            <section class="hero-section">
                <!-- 場所の画像 -->
                <div class="place-image">
                    <img src="{{ asset($place_img_path) }}" alt="{{ $place_name }}">
                </div>
                
                <!-- 評価と投稿 -->
                <div class="place-info">
                    <!-- 平均評価 -->
                    <div class="rating-card">
                        <div class="rating-score">★{{ number_format($place_recommend_avg, 1) }}</div>
                        <div class="rating-label">平均評価</div>
                    </div>
                    
                    <!-- 口コミ投稿 -->
                    <div class="post-action-card">
                        <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">口コミを投稿</h3>
                        <a class="post-btn" href="{{ route('posts.create', ['place_id' => $place_id]) }}">投稿する</a>
                    </div>
                </div>
            </section>
            
            <div class="sep"></div>
            
            <!-- 投稿一覧 -->
            <section class="posts-section">
                <h2 class="h2"><span>投稿一覧</span></h2>
                
                @foreach ($posts as $post)
                <article class="post-item">
                    <a href="{{ route('posts.show', $post->id) }}" class="post-clickable-area">
                        <div class="post-header">
                            <h2 class="post-title">{{ $post->title }}</h2>
                            <div class="post-rating">
                                <?= renderStars($post->recommend ?? 0) ?>(<?= htmlspecialchars($post->recommend ?? 0) ?>)
                            </div>
                        </div>
                        
                        <div>
                            @if($post->img_path)
                                <img src="{{ asset('storage/' . $post->img_path) }}" 
                                     class="post-image" 
                                     alt="レビュー画像">
                            @else
                                <div class="post-image" style="background: #f5f5f5; display: flex; align-items: center; justify-content: center; color: #999;">
                                    画像なし
                                </div>
                            @endif
                        </div>
                        
                        <div class="post-content">{{ $post->content }}</div>
                    </a>
                    
                    <div class="post-actions">
                        <button class="like-btn" 
                                data-liked="{{ $post->like && $post->like->contains('user_id', Auth::id()) ? 'true' : 'false' }}"
                                data-count="{{ $post->like ? $post->like->count() : 0 }}">
                            <img src="{{ $post->like && $post->like->contains('user_id', Auth::id()) ? '/images/heart_red.png' : '/images/heart_white.png' }}" 
                                 alt="いいね" 
                                 style="width:32px; height:32px; object-fit:contain;">
                        </button>
                        <span style="color: var(--muted); font-size: 0.9rem;">いいね <span class="like-count">{{ $post['like_count'] }}</span></span>
                    </div>
                    
                    <div class="post-meta">
                        <small>投稿者: {{ $post->user->name ?? '' }}</small>
                        <small>投稿日時: {{ $post['created_at'] }}</small>
                    </div>
                </article>
                @endforeach
            </section>
        </div>
    </div>
    
    <script src="/js/favo.js"></script>
</body>
</html>