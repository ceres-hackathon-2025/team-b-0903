<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>moddy </title>

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

    /* =========背景画像＋検索フォーム========= */
    .hero{
    position: relative;
    margin: .75rem auto 1.5rem;
    min-height: 420px;
    border-radius: 20px;
    overflow: clip; /* 互換なら hidden */
    background: url("{{ asset('images/home.png') }}") center/cover no-repeat #eee;
    box-shadow: 0 24px 50px rgba(0,0,0,.12);
    }

    .hero-inner{
    position: relative;
    z-index: 1;
    height: 100%;
    display: flex;
    align-items: center;   /* 縦中央 */
    justify-content: center; /* 横中央 */
    padding: 1.25rem;
    }

    /* 検索カード（半透明＋ぼかし） */
    .search-card{
      width: min(100%, 760px);
      background: rgba(255,255,255,.82);
      backdrop-filter: saturate(1.1) blur(6px);
      border: 1px solid rgba(0,0,0,.08);
      border-radius: var(--radius);
      box-shadow: 0 12px 30px rgba(0,0,0,.15);
      padding: .9rem;
    }
    .search-head{
      color:#3b2f2b; font-weight:800; margin: 0 0 .6rem; letter-spacing:.02em;
    }
    .search-form{ display:flex; flex-wrap:wrap; gap:.6rem; align-items:center; }
    .f{
      display:flex; align-items:center; gap:.5rem;
      background:#fff; border:1px solid rgba(0,0,0,.12);
      border-radius:12px; padding:.65rem .8rem;
    }
    .f input,.f select{
      border:0; outline:0; font-size:.98rem; min-width:180px; background:transparent;
    }
    .f-loc{
      color:#5a453f; font-weight:700;
      background:rgba(var(--base-rgb), .22); border-color: rgba(var(--base-rgb), .55);
    }
    .btn{
      appearance:none; border:0; cursor:pointer; padding:.8rem 1.1rem; border-radius:12px; font-weight:800;
      color:#fff; background:linear-gradient(180deg, var(--base), var(--base-strong));
      box-shadow:0 8px 20px rgba(var(--base-rgb), .45);
    }
    @media (max-width:640px){
      .hero{ min-height: 360px; }
      .search-card{ padding:.8rem }
      .f input,.f select{ min-width: 140px; }
    }

    /* 以降はオプション（おすすめ・カテゴリ） */
    .section{ margin: 1.5rem 0 2.2rem; }
    .h2{ display:flex; align-items:center; gap:.6rem; margin:0 0 .8rem; font-size:1.1rem; }
    .pill{ font-size:.75rem; border:1px solid rgba(var(--base-rgb), .55); background:rgba(var(--base-rgb), .22); color:#5a453f; border-radius:999px; padding:.1rem .5rem; }
    .grid{ display:grid; gap:1rem; }
    @media (min-width:720px){ .grid.cols-3{ grid-template-columns: repeat(3,1fr); } .grid.cols-4{ grid-template-columns: repeat(4,1fr); } }
    .card{ border:1px solid rgba(0,0,0,.08); border-radius:16px; background:#fff; box-shadow: 0 10px 28px rgba(0,0,0,.06); overflow:hidden; cursor:pointer; transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .card:hover{ transform: translateY(-2px); box-shadow: 0 15px 35px rgba(0,0,0,.12); }
    .card .ph{ aspect-ratio: 16/9; background:linear-gradient(135deg,#ffe6e1,#ffd1ca); display:flex; align-items:center; justify-content:center; color:#b07164; font-weight:900; overflow:hidden; }
    .card .ph img{ width:100%; height:100%; object-fit:cover; }
    .card .bd{ padding:.8rem .9rem 1rem }
    .card-link{ text-decoration: none; color: inherit; display: block; }
    .card .tt{ margin:.1rem 0 .35rem; font-weight:800 }
    .card .meta{ color:var(--muted); font-size:.85rem }
    .tag{ display:inline-block; margin:.25rem .35rem 0 0; font-size:.72rem; color:#5a453f; background:rgba(var(--base-rgb), .22); border:1px solid rgba(var(--base-rgb), .55); padding:.08rem .5rem; border-radius:999px }
    .sep{ height:1px; background:linear-gradient(90deg, transparent, rgba(0,0,0,.08), transparent); margin: 1.2rem 0 1.5rem; }
  </style>
</head>
<body>

  {{-- ヘッダー（既存のパーシャル） --}}
  @include('partials.header')

  <div class="container">
    <!-- ========= 画像 + 検索 ========= -->
    <section class="hero">
      <div class="hero-inner">
      </div>
    </section>

    <!-- 投稿一覧セクション -->
    <div class="sep"></div>
    <section class="section" id="posts-list">
      <h2 class="h2"><span>投稿一覧</span></h2>
      <div class="grid cols-3">
        @forelse ($posts as $post)
          <a href="{{ route('posts.show', $post->id) }}" class="card-link">
            <article class="card">
              <div class="ph" aria-hidden="true">
                @if ($post->img_path)
                  <img src="{{ asset('storage/' . $post->img_path) }}" alt="{{ $post->title }}">
                @else
                  画像なし
                @endif
              </div>
              <div class="bd">
                <div class="tt">{{ $post->title }}</div>
                <div class="meta">{{ $post->created_at->format('Y/m/d') }} ・ 投稿者: {{ $post->user->name ?? '匿名' }}</div>
                <p style="margin:.35rem 0 0">{{ $post->body }}</p>
                @if ($post->tags)
                  <div style="margin-top:.35rem">
                    @foreach ($post->tags as $tag)
                      <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                  </div>
                @endif
              </div>
            </article>
          </a>
        @empty
          <p>投稿がありません。</p>
        @endforelse
      </div>
    </section>

    <!-- （任意）以下は前回同様の固定値セクション -->
    <div class="sep"></div>

  <!-- 固定データ部分は削除 -->
  </div>

  <script>
  // 固定データ・描画処理は削除しました。
  </script>
</body>
</html>
