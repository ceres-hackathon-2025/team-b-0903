<header class="moddy-header" role="banner">
  <div class="moddy-wrap">

    <!-- brand -->
    <a class="moddy-brand" href="{{ url('/') }}" aria-label="moddy home">
    <img
        src="{{ asset('images/moddy_header.png') }}"
        alt=""
        class="moddy-logo-img moddy-logo--banner"   {{-- ← ここが重要！ --}}
        loading="eager" decoding="async"
    >
    </a>

    <!-- 食べログの検索ボックス風 “細枠コンテナ” に2項目 -->
    <nav class="moddy-toolbar" aria-label="primary">
      <a class="moddy-item is-active" href="#" data-key="review">口コミを投稿</a>
      <span class="moddy-sep" aria-hidden="true"></span>
      <a class="moddy-item" href="#" data-key="spot">スポットを探す</a>
    </nav>
  </div>
</header>

<style>
  :root{
    /* ベースカラー指定 */
    --base-rgb: 234,206,202;
    --base: rgb(var(--base-rgb));          /* #EACECA */
    --base-strong: rgb(199,149,141);       /* 濃いめアクセント */
    --ink: #2b2726;
    --muted: #6b6462;
    --paper: #ffffff;
    --hair: rgba(0,0,0,.12);
    --ring: rgba(var(--base-rgb), .5);
  }

  .moddy-header{
    position: sticky; top: 0; z-index: 50;
    background: #fffdfc;
    border-bottom: 1px solid rgba(0,0,0,.06);
    backdrop-filter: saturate(1.2) blur(2px);
  }
  .moddy-wrap{
    max-width: 1100px;
    margin: 0 auto;
    padding: .6rem 1rem;
    display: flex; align-items: center; gap: 12px;
  }

  /* brand */
    :root {
    --brand-size: 52px;          /* 48〜56pxあたりがヘッダーで映えます */
    }

    .moddy-brand{
    display: inline-flex;
    align-items: center;
    gap: 0;                       /* 画像だけなので余白ゼロ */
    text-decoration: none;
    line-height: 1;               /* 行間の余白を消す */
    }

    .moddy-logo-img{
    width: 120px;
    height: var(--brand-size);
    border-radius: 12px;          /* 角丸（お好みで調整 or 0） */
    display: block;               /* 画像下の隙間除去 */
    object-fit: cover;            /* 画像のはみ出し防止 */
    object-position: center;
    box-shadow: 0 4px 12px rgba(var(--base-rgb), .45); /* 任意：以前の雰囲気を踏襲 */
    }
  .moddy-title{ font-size: 1.15rem }
  .moddy-badge{
    display: inline-block; font-size: .72rem; font-weight: 700;
    color:#5a453f; border:1px solid rgba(var(--base-rgb), .6);
    background: rgba(var(--base-rgb), .25);
    padding:.12rem .45rem; border-radius: 999px;
    transform: translateY(-1px);
  }

  /* 食べログ風ツールバー（細枠・角丸） */
  .moddy-toolbar{
    margin-left: auto;
    display: flex; align-items: stretch;
    background: var(--paper);
    border: 1px solid var(--ring);
    border-radius: 12px;
    overflow: clip;
    box-shadow: 0 2px 8px rgba(0,0,0,.04) inset;
  }
  .moddy-item{
    display: inline-flex; align-items: center;
    padding: .6rem .9rem; min-height: 40px;
    color: var(--ink); text-decoration: none; font-weight: 600;
    white-space: nowrap;
    transition: background .15s ease, color .15s ease;
  }
  .moddy-item:hover{ background: rgba(var(--base-rgb), .16); }
  .moddy-item.is-active{
    background: rgba(var(--base-rgb), .22);
    color: #4a3a35;
  }
  .moddy-sep{
    width: 1px; background: linear-gradient(180deg, transparent, rgba(0,0,0,.12), transparent);
  }

  /* モバイル: 2項目を少しコンパクトに */
  @media (max-width: 640px){
    .moddy-title{ display:none }
    .moddy-badge{ display:none }
    .moddy-item{ padding: .55rem .7rem; font-weight: 700; }
  }
</style>

<script>
  // シンプルな「アクティブ切り替え」：URLから判定できるようになるまでは暫定でクリック時に付け替え
  (function(){
    const items = Array.from(document.querySelectorAll('.moddy-item'));
    items.forEach(a=>{
      a.addEventListener('click', (e)=>{
        // 実URLに差し替え後はこの preventDefault を外してください
        if (a.getAttribute('href') === '#') e.preventDefault();
        items.forEach(x=>x.classList.remove('is-active'));
        a.classList.add('is-active');
      });
    });

    // 将来的にルートで判定するなら（例: Laravel）
    // if (location.pathname.startsWith('/spots')) { activate('spot'); }
    // if (location.pathname.startsWith('/reviews')) { activate('review'); }
    function activate(key){
      items.forEach(x=>x.classList.toggle('is-active', x.dataset.key === key));
    }
  })();
</script>
