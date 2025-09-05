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
            <h1 class="display-3">{{ $place_name }}</h1>
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
                        @foreach ($posts as $post)
                        <article class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h2 class="card-title h5">{{ $post->title }}</h2>
                                    <div class="text-warning">
                                        {{ $post->rating ?? '' }}
                                    </div>
                                </div>
                                <!-- 画像を上に配置 -->
                                @if ($post->image_path)
                                <div class="mb-3">
                                    <img src="{{ asset($post->image_path) }}" 
                                         class="img-fluid rounded w-100" 
                                         style="height: 200px; object-fit: cover;" 
                                         alt="レビュー画像">
                                </div>
                                @endif
                                <!-- レビュー内容を下に配置 -->
                                <p class="card-text">{{ $post->content }}</p>
                                <!-- ハート形ボタンとお気に入り数 -->
                                <div class="d-flex align-items-center mb-2">
                                    <button class="btn btn-sm me-2 like-btn" 
                                            style="border-radius:50%; padding:0; width:32px; height:32px;"
                                            data-liked="{{ $post->like && $post->like->contains('user_id', Auth::id()) ? 'true' : 'false' }}"
                                            data-count="{{ $post->like ? $post->like->count() : 0 }}">
                                        <img src="{{ $post->like && $post->like->contains('user_id', Auth::id()) ? '/images/heart_red.png' : '/images/heart_white.png' }}" 
                                             alt="いいね" 
                                             style="width:32px; height:32px; object-fit:contain;">
                                    </button>
                                    <span class="text-muted fs-6">いいね <span class="like-count">{{ $post->like ? $post->like->count() : 0 }}</span></span>
                                </div>
                                <footer class="text-muted d-flex justify-content-between mt-2">
                                    <small>投稿者: {{ $post->user->name ?? '' }}</small>
                                    <small>投稿日: {{ $post->created_at->format('Y-m-d') }}</small>
                                </footer>
                            </div>
                        </article>
                        @endforeach
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
