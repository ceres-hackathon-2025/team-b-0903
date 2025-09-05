<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>moddy | 投稿詳細</title>

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

    .container{ max-width:var(--maxw); margin:0 auto; padding: 1rem; }

    .header{ margin: .75rem auto 1.5rem; padding: 1rem; text-align: center; }
    .page-title{ font-size: 2rem; font-weight: 800; color: var(--ink); margin: 0 0 .5rem; }
    .breadcrumb{ color: var(--muted); font-size: .9rem; }
    .breadcrumb a{ color: var(--base-strong); text-decoration: none; }

    .main-content{ max-width: 700px; margin: 0 auto; padding: 0 1rem; }

    .post-card{ background: #fff; border: 1px solid rgba(0,0,0,.08); border-radius: var(--radius); box-shadow: 0 10px 28px rgba(0,0,0,.06); overflow: hidden; }
    .post-header{ padding: 1.2rem; border-bottom: 1px solid rgba(0,0,0,.08); }
    .post-title{ font-size: 1.5rem; font-weight: 800; margin: 0 0 .5rem; }
    .post-meta{ display: flex; align-items: center; gap: .8rem; color: var(--muted); font-size: .9rem; }
    .rating{ color: #ffa500; }

    .post-image{ width: 100%; height: 300px; object-fit: cover; background: linear-gradient(135deg,#ffe6e1,#ffd1ca); }

    .post-content{ padding: 1.2rem; }
    .post-text{ line-height: 1.6; margin: 0 0 1rem; white-space: pre-wrap; }

    .like-section{ display: flex; align-items: center; gap: .8rem; padding: 1rem 1.2rem; border-top: 1px solid rgba(0,0,0,.08); background: rgba(var(--base-rgb), .05); }
    .like-btn{ appearance:none; border:0; cursor:pointer; background:transparent; padding:.5rem; border-radius:50%; transition: transform .2s; }
    .like-btn:hover{ transform: scale(1.1); }
    .like-count{ color: var(--muted); font-size: .9rem; }

    .post-footer{ display: flex; justify-content: space-between; padding: 1rem 1.2rem; border-top: 1px solid rgba(0,0,0,.08); color: var(--muted); font-size: .85rem; }

    @media (max-width: 767px){
      .post-title{ font-size: 1.3rem; }
    }
  </style>
</head>
<body>

  {{-- 既存ヘッダー（都道府県プルダウン等があるパーシャル） --}}
  @include('partials.header')

  <div class="container">
    <header class="header">
      <h1 class="page-title">投稿詳細</h1>
    </header>

    <div class="main-content">
      <main>
        <article class="post-card">
          <header class="post-header">
            <h2 class="post-title">{{ $postPayload['title'] ?? '' }}</h2>
            <div class="post-meta">
              <span class="rating">{{ $postPayload['recommend'] ?? '' }}</span>
              <span>{{ $postPayload['place'] ?? '' }}</span>
            </div>
          </header>

          <img src="{{ $postPayload['img_path'] ?? asset('images/noimage.png') }}" alt="投稿画像" class="post-image">

          <div class="post-content">
            <p class="post-text">{{ $postPayload['text'] ?? '' }}</p>
          </div>

          <div class="like-section">
            <button class="like-btn" data-liked="false" data-count="{{ $postPayload['count_like'] ?? 0 }}">
              <img src="{{ asset('images/heart_white.png') }}" alt="いいね" style="width:24px; height:24px;">
            </button>
            <span class="like-count">
              いいね <span class="like-count-num">{{ $postPayload['count_like'] ?? 0 }}</span>件
            </span>
          </div>

          <footer class="post-footer">
            <span>投稿者: {{ $postPayload['user'] ?? '名無し' }}</span>
            <span>投稿日: {{ $postPayload['date'] ?? '' }}</span>
            <a href="{{ route('posts.byPlaceWithPrefecture', ['place' => request('place_id', $postPayload['place_id'] ?? '')]) }}" class="btn btn-ghost">投稿一覧に戻る</a>
          </footer>
        </article>
      </main>
    </div>
  </div>

  <script src="{{ asset('js/favo.js') }}"></script>
</body>
</html>
