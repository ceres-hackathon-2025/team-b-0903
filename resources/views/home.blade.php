<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>moddy | 奈良のデートスポット</title>

  <style>
    /* ========== ベース色（前に作ったヘッダーと同じトーン） ========== */
    :root{
      --base-rgb: 234,206,202;
      --base: rgb(var(--base-rgb));
      --base-strong: rgb(199,149,141);
      --ink:#2b2726; --muted:#6b6462; --paper:#fff;
      --ring: rgba(var(--base-rgb), .55);
      --hair: rgba(0,0,0,.12);
      --maxw: 1100px;           /* コンテンツ幅 */
      --radius: 14px;
    }

    /* ========== レイアウト ========== */
    body{ margin:0; color:var(--ink); font-family:system-ui,-apple-system,Segoe UI,Roboto,"Noto Sans JP",sans-serif; background:#fffdfa; }
    .container{ max-width:var(--maxw); margin:0 auto; padding: 1rem; }
    .section{ margin: 1.25rem 0 2.25rem; }

    /* ========== HERO（検索） ========== */
    .hero{
      margin-top: .5rem;
      border-radius: 20px;
      background:
        radial-gradient(900px 400px at 80% -10%, rgba(var(--base-rgb), .28), transparent 60%),
        radial-gradient(900px 500px at -10% 10%, rgba(var(--base-rgb), .18), transparent 60%),
        #fff;
      box-shadow: 0 20px 40px rgba(0,0,0,.06);
      border: 1px solid rgba(0,0,0,.05);
      overflow: clip;
    }
    .hero-head{ padding: 1.1rem 1.25rem .25rem; }
    .hero-head h1{ margin:0; font-size:1.35rem; letter-spacing:.02em }
    .hero-head .sub{ margin:.35rem 0 0; color:var(--muted); font-size:.92rem }
    .hero-form{ display:flex; gap:.6rem; padding: .9rem 1.25rem 1.25rem; flex-wrap:wrap; align-items:center }
    .f{ position:relative; display:flex; align-items:center; gap:.5rem; background:#fff; border:1px solid rgba(0,0,0,.12); padding:.65rem .8rem; border-radius:12px; }
    .f input,.f select{
      border:0; outline:0; font-size:.98rem; min-width:180px; background:transparent;
    }
    .f-loc{ color:#5a453f; font-weight:700; background:rgba(var(--base-rgb), .22); border:1px solid rgba(var(--base-rgb), .55) }
    .btn{
      appearance:none; border:0; cursor:pointer; padding:.8rem 1.1rem; border-radius:12px; font-weight:800;
      color:#fff; background:linear-gradient(180deg, var(--base), var(--base-strong));
      box-shadow:0 8px 20px rgba(var(--base-rgb), .45);
    }

    /* ========== セクション見出し ========== */
    .h2{ display:flex; align-items:center; gap:.6rem; margin:0 0 .8rem; font-size:1.1rem; }
    .h2 .pill{ font-size:.75rem; border:1px solid rgba(var(--base-rgb), .55); background:rgba(var(--base-rgb), .22); color:#5a453f; border-radius:999px; padding:.1rem .5rem; }
    .grid{ display:grid; gap:1rem; }
    @media (min-width:720px){ .grid.cols-3{ grid-template-columns: repeat(3,1fr); } .grid.cols-4{ grid-template-columns: repeat(4,1fr); } }

    /* ========== カード ========== */
    .card{ border:1px solid rgba(0,0,0,.08); border-radius:16px; background:#fff; box-shadow: 0 10px 28px rgba(0,0,0,.06); overflow:hidden }
    .card .ph{ aspect-ratio: 16/9; background:linear-gradient(135deg,#ffe6e1,#ffd1ca); display:flex; align-items:center; justify-content:center; color:#b07164; font-weight:900; letter-spacing:.02em }
    .card .bd{ padding:.8rem .9rem 1rem }
    .card .tt{ margin:.1rem 0 .35rem; font-weight:800 }
    .card .meta{ color:var(--muted); font-size:.85rem }
    .stars{ color:#f59e0b; font-size:.95rem; letter-spacing:.04em }
    .tag{ display:inline-block; margin:.25rem .35rem 0 0; font-size:.72rem; color:#5a453f; background:rgba(var(--base-rgb), .22); border:1px solid rgba(var(--base-rgb), .55); padding:.08rem .5rem; border-radius:999px }

    /* ========== カテゴリ ========== */
    .chips{ display:flex; gap:.5rem; flex-wrap:wrap }
    .chip{
      display:inline-flex; align-items:center; gap:.4rem; padding:.55rem .8rem; border-radius:999px;
      border:1px solid rgba(0,0,0,.12); background:#fff; cursor:pointer; font-weight:700;
    }
    .chip.is-on{ border-color: var(--base-strong); box-shadow: 0 0 0 4px rgba(var(--base-rgb), .18) inset; }

    /* ========== 結果 ========== */
    .results-empty{ padding:1rem; color:var(--muted) }

    /* セクション間の薄い区切り */
    .sep{ height:1px; background:linear-gradient(90deg, transparent, rgba(0,0,0,.08), transparent); margin: 1.2rem 0 1.5rem; }
  </style>
</head>
<body>

  {{-- ヘッダー（前に作った partial を読み込み） --}}
  @include('partials.header')

  <div class="container">

    <!-- ===== 検索（奈良限定） ===== -->
    <section class="hero section" id="search">
      <div class="hero-head">
        <h1>奈良で、ぴったりのデートスポットを探す</h1>
        <p class="sub">キーワードやカテゴリで、サクッと絞り込み。</p>
      </div>
      <form class="hero-form" id="searchForm">
        <div class="f f-loc">
          <span>奈良限定</span>
        </div>
        <div class="f">
          <input id="q" name="q" type="text" placeholder="例：鹿、夜景、映える" autocomplete="off">
        </div>
        <div class="f">
          <select id="cat" name="cat" aria-label="カテゴリ">
            <option value="">カテゴリを選択</option>
            <option>お寺</option>
            <option>遊園地</option>
            <option>公園</option>
            <option>美術館</option>
            <option>カフェ</option>
            <option>夜景</option>
            <option>雨でもOK</option>
          </select>
        </div>
        <button class="btn" type="submit">検索</button>
      </form>
    </section>

    <div class="sep"></div>

    <!-- ===== おすすめレビュー ===== -->
    <section class="section" id="recommend">
      <h2 class="h2"><span>おすすめレビュー</span><span class="pill">奈良</span></h2>
      <div class="grid cols-3" id="reviewsGrid">
        <!-- JSで埋め込み -->
      </div>
    </section>

    <div class="sep"></div>

    <!-- ===== カテゴリで探す ===== -->
    <section class="section" id="byCategory">
      <h2 class="h2"><span>カテゴリから探す</span><span class="pill">お寺 / 遊園地 / 公園 …</span></h2>
      <div class="chips" id="chips">
        <button class="chip" data-cat="お寺">お寺</button>
        <button class="chip" data-cat="遊園地">遊園地</button>
        <button class="chip" data-cat="公園">公園</button>
        <button class="chip" data-cat="美術館">美術館</button>
        <button class="chip" data-cat="カフェ">カフェ</button>
        <button class="chip" data-cat="夜景">夜景</button>
        <button class="chip" data-cat="雨でもOK">雨でもOK</button>
      </div>

      <div class="section" style="margin-top:1rem">
        <div class="grid cols-4" id="spotsGrid">
          <!-- JSで埋め込み -->
        </div>
        <div class="results-empty" id="spotsEmpty" hidden>該当するスポットがありませんでした。</div>
      </div>
    </section>

  </div>

  <script>
    // ====== 固定データ（奈良のみ） ======
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

    // ====== DOM参照 ======
    const reviewsGrid = document.getElementById('reviewsGrid');
    const spotsGrid = document.getElementById('spotsGrid');
    const spotsEmpty = document.getElementById('spotsEmpty');
    const chips = document.getElementById('chips');
    const form = document.getElementById('searchForm');
    const q = document.getElementById('q');
    const cat = document.getElementById('cat');

    // ====== 表示ユーティリティ ======
    const stars = n => '★★★★★☆☆☆☆☆'.slice(5 - Math.max(0, Math.min(5, n)), 10 - Math.max(0, Math.min(5, n)));

    function CardSpot(s){
      const tags = (s.tags||[]).map(t=>`<span class="tag">${t}</span>`).join('');
      return `
        <article class="card">
          <div class="ph" aria-hidden="true">${s.img}</div>
          <div class="bd">
            <div class="tt">${s.name}</div>
            <div class="meta">${s.town} ・ <span class="pill">${s.cat}</span></div>
            <div style="margin-top:.35rem">${tags}</div>
          </div>
        </article>
      `;
    }

    function CardReview(r){
      const s = spots.find(x=>x.id===r.spotId);
      return `
        <article class="card">
          <div class="ph" aria-hidden="true">${s ? s.img : 'スポット'}</div>
          <div class="bd">
            <div class="tt">${s ? s.name : 'スポット'}</div>
            <div class="stars" aria-label="評価">${'★'.repeat(r.rating)}${'☆'.repeat(5-r.rating)} <span style="color:var(--muted);font-size:.9rem">(${r.rating}.0)</span></div>
            <p style="margin:.35rem 0 0">${r.body}</p>
          </div>
        </article>
      `;
    }

    function renderReviews(items){
      reviewsGrid.innerHTML = items.slice(0,6).map(CardReview).join('');
    }

    function renderSpots(items){
      spotsGrid.innerHTML = items.map(CardSpot).join('');
      spotsEmpty.hidden = items.length !== 0;
    }

    // 初期描画
    renderReviews(reviews);
    renderSpots(spots);

    // ====== 検索 ======
    form.addEventListener('submit', (e)=>{
      e.preventDefault();
      const kw = (q.value||'').trim();
      const c = (cat.value||'').trim();
      const res = spots.filter(s=>{
        if (c && s.cat !== c) return false;
        if (!kw) return true;
        const hay = [s.name, s.town, ...(s.tags||[])].join(' ');
        return hay.includes(kw);
      });
      renderSpots(res);
      // 検索後、カテゴリの選択状態を解除
      chips.querySelectorAll('.chip').forEach(x=>x.classList.remove('is-on'));
      // 結果へスクロール
      document.getElementById('byCategory').scrollIntoView({behavior:'smooth', block:'start'});
    });

    // ====== カテゴリ chips ======
    chips.addEventListener('click', (e)=>{
      const b = e.target.closest('.chip'); if(!b) return;
      chips.querySelectorAll('.chip').forEach(x=>x.classList.remove('is-on'));
      b.classList.add('is-on');
      const c = b.dataset.cat;
      const res = spots.filter(s=>s.cat===c);
      renderSpots(res);
    });
  </script>
</body>
</html>
