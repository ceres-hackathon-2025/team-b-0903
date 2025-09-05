<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>moddy | 奈良のデートスポット</title>

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
    .card{ border:1px solid rgba(0,0,0,.08); border-radius:16px; background:#fff; box-shadow: 0 10px 28px rgba(0,0,0,.06); overflow:hidden }
    .card .ph{ aspect-ratio: 16/9; background:linear-gradient(135deg,#ffe6e1,#ffd1ca); display:flex; align-items:center; justify-content:center; color:#b07164; font-weight:900 }
    .card .bd{ padding:.8rem .9rem 1rem }
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

    <!-- （任意）以下は前回同様の固定値セクション -->
    <div class="sep"></div>

    <section class="section" id="recommend">
      <h2 class="h2"><span>おすすめレビュー</span><span class="pill">奈良</span></h2>
      <div class="grid cols-3" id="reviewsGrid"></div>
    </section>

    <div class="sep"></div>

    <section class="section" id="byCategory">
      <h2 class="h2"><span>カテゴリから探す</span><span class="pill">お寺 / 遊園地 / 公園 …</span></h2>
      <div class="grid cols-4" id="spotsGrid"></div>
    </section>
  </div>

  <script>
    /* 固定データ（奈良） */
    const spots = [
      { id:1, name:'奈良公園', town:'奈良市', cat:'公園', tags:['鹿','広い','散策'], img:'奈良公園' },
      { id:2, name:'東大寺', town:'奈良市', cat:'お寺', tags:['大仏','世界遺産'], img:'東大寺' },
      { id:3, name:'春日大社', town:'奈良市', cat:'お寺', tags:['灯篭','神社'], img:'春日大社' },
      { id:4, name:'平城宮跡歴史公園', town:'奈良市', cat:'公園', tags:['歴史','芝生'], img:'平城宮跡' },
      { id:5, name:'若草山', town:'奈良市', cat:'夜景', tags:['夜景','ドライブ'], img:'若草山' },
      { id:6, name:'ならまちカフェめぐり', town:'奈良市', cat:'カフェ', tags:['古民家','映え'], img:'ならまち' },
      { id:7, name:'生駒山上遊園地', town:'生駒市', cat:'遊園地', tags:['絶景','観覧車'], img:'生駒山上' },
      { id:8, name:'奈良県立美術館', town:'奈良市', cat:'美術館', tags:['雨でもOK','静か'], img:'美術館' },
    ];
    const reviews = [
      { id:101, spotId:1, rating:5, body:'鹿と触れ合えて癒やされる。夕方が映える！' },
      { id:102, spotId:2, rating:4, body:'大仏の迫力に圧倒。周辺の茶屋でほっと一息。' },
      { id:103, spotId:7, rating:4, body:'観覧車からの眺めが最高。夜は特にロマンチック。' },
      { id:104, spotId:5, rating:5, body:'若草山からの夜景は圧巻。車ならアクセスも楽。' },
      { id:105, spotId:6, rating:4, body:'ならまちの古民家カフェでまったりデート。' },
      { id:106, spotId:8, rating:4, body:'雨でも楽しめる静かな美術館デート。' },
    ];

    const reviewsGrid = document.getElementById('reviewsGrid');
    const spotsGrid = document.getElementById('spotsGrid');

    const CardSpot = s => `
      <article class="card">
        <div class="ph" aria-hidden="true">${s.img}</div>
        <div class="bd">
          <div class="tt">${s.name}</div>
          <div class="meta">${s.town} ・ <span class="pill">${s.cat}</span></div>
          <div style="margin-top:.35rem">${(s.tags||[]).map(t=>`<span class="tag">${t}</span>`).join('')}</div>
        </div>
      </article>
    `;
    const CardReview = r => {
      const s = spots.find(x=>x.id===r.spotId);
      return `
        <article class="card">
          <div class="ph" aria-hidden="true">${s ? s.img : 'スポット'}</div>
          <div class="bd">
            <div class="tt">${s ? s.name : 'スポット'}</div>
            <div class="meta">評価：${'★'.repeat(r.rating)}${'☆'.repeat(5-r.rating)} (${r.rating}.0)</div>
            <p style="margin:.35rem 0 0">${r.body}</p>
          </div>
        </article>
      `;
    };

    const renderReviews = items => reviewsGrid.innerHTML = items.slice(0,3).map(CardReview).join('');
    const renderSpots = items => spotsGrid.innerHTML = items.map(CardSpot).join('');

    // 初期描画
    renderReviews(reviews);
    renderSpots(spots);

    // 検索フォーム（ヒーロー内）
    document.getElementById('searchForm').addEventListener('submit', e=>{
      e.preventDefault();
      const kw = (document.getElementById('q').value||'').trim();
      const c  = (document.getElementById('cat').value||'').trim();
      const res = spots.filter(s=>{
        if (c && s.cat !== c) return false;
        if (!kw) return true;
        return [s.name, s.town, ...(s.tags||[])].join(' ').includes(kw);
      });
      renderSpots(res);
      document.getElementById('byCategory').scrollIntoView({behavior:'smooth', block:'start'});
    });
  </script>
</body>
</html>
