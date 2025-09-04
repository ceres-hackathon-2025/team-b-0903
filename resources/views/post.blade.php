<?php
$post = [
    'title' => '最高のサービスでした！',
    'recommend' => '★★★★★',
    'text' => 'スタッフの対応が非常に丁寧で、料理も美味しく大満足でした。また利用したいと思います。特にパスタが絶品でした！',
    'user' => '田中太郎さん',
    'place' => '東大寺',
    'date' => '2024年3月15日',
    'image_path' => './img/test02.jpg',
    'count_like' => 34,
]
?>
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

    /* コンテナ */
    .container{ max-width:var(--maxw); margin:0 auto; padding: 1rem; }

    /* ヘッダー */
    .header{
      margin: .75rem auto 1.5rem;
      padding: 1rem;
      text-align: center;
    }
    .page-title{
      font-size: 2rem; font-weight: 800; color: var(--ink);
      margin: 0 0 .5rem;
    }
    .breadcrumb{
      color: var(--muted); font-size: .9rem;
    }
    .breadcrumb a{
      color: var(--base-strong); text-decoration: none;
    }

    /* メインコンテンツエリア */
    .main-content{
      display: grid;
      gap: 1.5rem;
      grid-template-columns: 1fr;
    }
    @media (min-width: 768px){
      .main-content{
        grid-template-columns: 2fr 1fr;
      }
    }

    /* 投稿詳細カード */
    .post-card{
      background: #fff;
      border: 1px solid rgba(0,0,0,.08);
      border-radius: var(--radius);
      box-shadow: 0 10px 28px rgba(0,0,0,.06);
      overflow: hidden;
    }
    .post-header{
      padding: 1.2rem;
      border-bottom: 1px solid rgba(0,0,0,.08);
    }
    .post-title{
      font-size: 1.5rem; font-weight: 800; margin: 0 0 .5rem;
    }
    .post-meta{
      display: flex; align-items: center; gap: .8rem;
      color: var(--muted); font-size: .9rem;
    }
    .rating{
      color: #ffa500;
    }

    /* 投稿画像 */
    .post-image{
      width: 100%; height: 300px;
      object-fit: cover;
      background: linear-gradient(135deg,#ffe6e1,#ffd1ca);
    }

    /* 投稿内容 */
    .post-content{
      padding: 1.2rem;
    }
    .post-text{
      line-height: 1.6; margin: 0 0 1rem;
    }

    /* いいねボタン */
    .like-section{
      display: flex; align-items: center; gap: .8rem;
      padding: 1rem 1.2rem;
      border-top: 1px solid rgba(0,0,0,.08);
      background: rgba(var(--base-rgb), .05);
    }
    .like-btn{
      appearance: none; border: 0; cursor: pointer;
      background: transparent; padding: .5rem;
      border-radius: 50%;
      transition: transform 0.2s;
    }
    .like-btn:hover{
      transform: scale(1.1);
    }
    .like-count{
      color: var(--muted); font-size: .9rem;
    }

    /* サイドバー */
    .sidebar{
      display: flex; flex-direction: column; gap: 1.5rem;
    }

    /* 統計カード */
    .stats-card{
      background: #fff;
      border: 1px solid rgba(0,0,0,.08);
      border-radius: var(--radius);
      box-shadow: 0 10px 28px rgba(0,0,0,.06);
      padding: 1.2rem;
      text-align: center;
    }
    .stats-rating{
      font-size: 2.5rem; font-weight: 800;
      color: #ffa500; margin: 0 0 .5rem;
    }
    .stats-label{
      color: var(--ink); font-weight: 600; margin: 0 0 .3rem;
    }
    .stats-count{
      color: var(--muted); font-size: .9rem;
    }

    /* アクションカード */
    .action-card{
      background: #fff;
      border: 1px solid rgba(0,0,0,.08);
      border-radius: var(--radius);
      box-shadow: 0 10px 28px rgba(0,0,0,.06);
      padding: 1.2rem;
    }
    .action-title{
      font-weight: 800; margin: 0 0 .8rem;
    }
    .btn{
      appearance: none; border: 0; cursor: pointer;
      padding: .8rem 1.2rem; border-radius: 12px;
      font-weight: 700; width: 100%;
      color: #fff;
      background: linear-gradient(180deg, var(--base), var(--base-strong));
      box-shadow: 0 8px 20px rgba(var(--base-rgb), .45);
      transition: transform 0.2s;
    }
    .btn:hover{
      transform: translateY(-2px);
    }

    /* フッター情報 */
    .post-footer{
      display: flex; justify-content: space-between;
      padding: 1rem 1.2rem;
      border-top: 1px solid rgba(0,0,0,.08);
      color: var(--muted); font-size: .85rem;
    }

    /* タグ */
    .tag{
      display: inline-block; margin: .25rem .35rem 0 0;
      font-size: .72rem; color: #5a453f;
      background: rgba(var(--base-rgb), .22);
      border: 1px solid rgba(var(--base-rgb), .55);
      padding: .08rem .5rem; border-radius: 999px;
    }

    /* レスポンシブ調整 */
    @media (max-width: 767px){
      .post-title{ font-size: 1.3rem; }
      .stats-rating{ font-size: 2rem; }
    }
  </style>
</head>
<body>

  {{-- ヘッダー（既存のパーシャル） --}}
  @include('partials.header')

  <div class="container">
    <!-- ページヘッダー -->
    <header class="header">
      <h1 class="page-title">投稿詳細</h1>
      <!-- <nav class="breadcrumb">
        <a href="/">ホーム</a> > <a href="/places">場所一覧</a> > 投稿詳細
      </nav> -->
    </header>

    <!-- メインコンテンツ -->
    <div class="main-content">
      <!-- 投稿詳細 -->
      <main>
        <article class="post-card">
          <!-- 投稿ヘッダー -->
          <header class="post-header">
            <h2 class="post-title"><?= htmlspecialchars($post['title']) ?></h2>
            <div class="post-meta">
              <span class="rating"><?= htmlspecialchars($post['recommend']) ?></span>
              <span><?= htmlspecialchars($post['place']) ?></span>
              <!-- <span class="tag">付き合う前</span> -->
            </div>
          </header>

          <!-- 投稿画像 -->
          <img src="<?= htmlspecialchars($post['image_path']) ?>" alt="投稿画像" class="post-image">

          <!-- 投稿内容 -->
          <div class="post-content">
            <p class="post-text">
              <?= htmlspecialchars($post['text']) ?>
            </p>
          </div>

          <!-- いいねセクション -->
          <div class="like-section">
            <button class="like-btn" data-liked="false" data-count="34">
              <img src="/images/heart_white.png" alt="いいね" style="width:24px; height:24px;">
            </button>
            <span class="like-count">いいね <span class="like-count-num"><?= htmlspecialchars($post['count_like']) ?></span>件</span>
          </div>

          <!-- 投稿フッター -->
          <footer class="post-footer">
            <span>投稿者: <?= htmlspecialchars($post['user']) ?></span>
            <span>投稿日: <?= htmlspecialchars($post['date']) ?></span>
          </footer>
        </article>
      </main>

      <!--
      <aside class="sidebar">
        <div class="stats-card">
          <div class="stats-rating">★4.2</div>
          <h3 class="stats-label">平均評価</h3>
          <p class="stats-count">247件のレビュー</p>
        </div>

        <div class="action-card">
          <h3 class="action-title">この場所について</h3>
          <button class="btn" type="button">詳細を見る</button>
        </div>

        <div class="action-card">
          <h3 class="action-title">レビューを投稿</h3>
          <button class="btn" type="button">レビューを書く</button>
        </div>
      </aside> -->
    </div>
  </div>

  <script src="/js/favo.js"></script>
</body>
</html>
