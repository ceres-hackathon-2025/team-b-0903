<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- 親要素IDをhiddenで保持 -->
        @isset($place_id)
            <input type="hidden" id="place_id" value="{{ $place_id }}">
        @endisset
        @isset($prefecture_id)
            <input type="hidden" id="prefecture_id" value="{{ $prefecture_id }}">
        @endisset
        <!-- 大きな見出し - 上部中央 -->
        <header class="text-center my-4">
            <h1 class="display-3">投稿一覧</h1>
            @isset($place_id)
                <div>観光地ID: {{ $place_id }}</div>
            @endisset
            @isset($prefecture_id)
                <div>都道府県ID: {{ $prefecture_id }}</div>
            @endisset
        </header>
        <main>
            <div class="row">
                <div class="col-md-8">
                    <h2 class="h4 mb-3">投稿一覧</h2>
                    @foreach ($posts as $post)
                    <article class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h2 class="card-title h5">{{ $post->title }}</h2>
                                <div class="text-warning">
                                    @if(isset($post->recommend))
                                        {{ $post->recommend ? 'おすすめ' : '' }}
                                    @endif
                                </div>
                            </div>
                            @if($post->image_path)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $post->image_path) }}" 
                                     class="img-fluid rounded w-100" 
                                     style="height: 200px; object-fit: cover;" 
                                     alt="投稿画像">
                            </div>
                            @endif
                            <p class="card-text">{{ $post->content }}</p>
                            <footer class="text-muted d-flex justify-content-between mt-2">
                                <small>投稿者: {{ $post->user->name ?? '不明' }}</small>
                                <small>投稿日: {{ $post->created_at }}</small>
                            </footer>
                        </div>
                    </article>
                    @endforeach
                </div>
                <aside class="col-md-4">
                    <!-- サイドバーなど必要に応じて追加 -->
                </aside>
            </div>
        </main>
        <footer class="mt-5 text-center">
            <p>&copy; 2025 投稿一覧</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
