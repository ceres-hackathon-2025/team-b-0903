<header class="moddy-header" role="banner">
  <div class="moddy-wrap">

    <!-- brand（左） -->
    <a class="moddy-brand" href="{{ url('/') }}" aria-label="moddy home">
      <img
        src="{{ asset('images/moddy_header.png') }}"
        alt=""
        class="moddy-logo-img moddy-logo--banner"
        loading="eager" decoding="async"
      >
    </a>

    <!-- 中央：検索（都道府県のみ） -->
    <div class="moddy-center">
      <form class="moddy-search" id="headerPrefSearch" role="search" onsubmit="return goPref(event)">
        @php($selected = (string)old('pref', request('pref', '')))
        <label class="sr-only" for="pref">都道府県</label>
        <select id="pref" name="pref" class="moddy-select" aria-label="都道府県" required>
          <option value="">都道府県</option>
          @foreach ($prefectures as $pref)
            <option value="{{ $pref->id }}" @selected($selected === (string)$pref->id)>{{ $pref->name }}</option>
          @endforeach
        </select>

        <button class="btn-search" type="submit" aria-label="検索">
          <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="currentColor" d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 10-.71.71l.27.28v.79L20 21.5 21.5 20 15.5 14zm-6 0A4.5 4.5 0 1114 9.5 4.5 4.5 0 019.5 14z"/>
          </svg>
          <span class="sr-only">検索</span>
        </button>
      </form>
    </div>

    <!-- 右：ログイン / userID -->
    <div class="moddy-actions">
      @guest
        <a class="login-btn" href="{{ url('/login') }}" aria-label="ログインへ">ログイン</a>
      @endguest
      @auth
        <span class="user-chip">ユーザー: {{ Auth::user()->name }}</span>
      @endauth
    </div>

  </div>
</header>


<style>
  :root{
    --base-rgb: 234,206,202;
    --base: rgb(var(--base-rgb));
    --base-strong: rgb(199,149,141);
    --ink: #2b2726;
    --muted: #6b6462;
    --paper: #ffffff;
    --ring: rgba(var(--base-rgb), .5);
    --brand-size: 52px;
  }

  /* ===== Header ===== */
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
    flex-wrap: wrap; /* モバイルで折り返し */
  }

  /* brand（左） */
  .moddy-brand{
    display: inline-flex; align-items: center; gap: 0;
    text-decoration: none; line-height: 1;
  }
  .moddy-logo-img{
    width: 120px;
    height: var(--brand-size);
    border-radius: 12px;
    display: block;
    object-fit: cover; object-position: center;
    box-shadow: 0 4px 12px rgba(var(--base-rgb), .45);
  }

  /* 中央寄せは維持 */
  .moddy-center{
    flex: 1;
    display: flex;
    justify-content: center;
  }

  /* 検索枠が勝手に広がらないよう固定気味に */
  /* 検索ボックス */
  .moddy-search{
    display: inline-flex;
    align-items: center;
    gap: .6rem;

    height: 44px;                  /* 既存と同じ高さ */
    padding: 0 .75rem;             /* ← 横方向の余白を増やす */
    background: #fff;

    /* 枠線をピンク系に */
    border: 2px solid rgba(var(--base-rgb), .9); /* #EACECA に近い色味 */
    border-radius: 12px;

    /* ほんのり内側の陰影（任意） */
    box-shadow: 0 1px 3px rgba(0,0,0,.03) inset;
  }


  @media (max-width:640px){
    .moddy-search{ width: min(92vw, 420px); }
  }
  
  /* セレクトの見た目を枠に合わせる（Safari対応含む） */
  .moddy-select{
    -webkit-appearance: none;
    appearance: none;
    border: 0; outline: 0;
    background: transparent;
    color: var(--ink);
    font-weight: 700;

    /* ★枠の高さにフィット */
    height: 100%;
    line-height: 44px;
    padding: 0 .6rem;
    min-width: 9.5rem;
  }

  /* 検索ボタンのサイズを枠に合わせる（影も角内に収まる） */
  .btn-search{
    appearance: none; border: 0; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center;

    /* ★枠の高さと同じにする */
    width: 40px; height: 40px;        /* 44pxの枠 + 2px境界でちょうどよく収まる */
    flex: 0 0 40px;
    margin: 0;

    border-radius: 10px;
    color: #fff;
    background: linear-gradient(180deg, var(--base), var(--base-strong));
    box-shadow: 0 6px 16px rgba(var(--base-rgb), .35);
    transition: filter .15s ease, transform .06s ease;
  }
  .btn-search:hover{ filter: brightness(1.05); transform: translateY(-1px); }

  .btn-search{
    appearance: none; border: 0; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center;
    width: 38px; height: 38px; border-radius: 10px;
    color: #fff; background: linear-gradient(180deg, var(--base), var(--base-strong));
    box-shadow: 0 6px 16px rgba(var(--base-rgb), .35);
    transition: filter .15s ease, transform .06s ease;
  }
  .btn-search:hover{ filter: brightness(1.05); transform: translateY(-1px); }

  /* 右（ログイン or userID） */
  .moddy-actions{
    margin-left: auto;
    display: flex; align-items: center; gap: .5rem;
  }
  .login-btn{
    display: inline-flex; align-items: center; justify-content: center;
    padding: .5rem .9rem; border-radius: 999px; text-decoration: none;
    font-weight: 700; color:#5a453f;
    border: 1px solid rgba(var(--base-rgb), .55);
    background: rgba(var(--base-rgb), .22);
    transition: background .15s, transform .06s;
  }
  .login-btn:hover{ background: rgba(var(--base-rgb), .3); transform: translateY(-1px); }
  .user-chip{
    display: inline-flex; align-items: center;
    padding: .5rem .8rem; border-radius: 999px;
    background: #fff; color: #4a3a35;
    border: 1px solid rgba(0,0,0,.08); font-weight: 700;
  }

  /* アクセシビリティ（画面外ラベル） */
  .sr-only{
    position:absolute !important; width:1px; height:1px;
    padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0);
    white-space:nowrap; border:0;
  }

  /* モバイル */
  @media (max-width: 640px){
    .moddy-center{
      order: 3; width: 100%; justify-content: center; margin-top: .5rem;
    }
    .moddy-actions{ order: 2; margin-left: auto; }
    .moddy-brand  { order: 1; }
  }
</style>


<script>
  // /prefectures/{id} に遷移
  function goPref(e){
    e.preventDefault();
    const sel = document.getElementById('pref');
    const id  = sel && sel.value ? String(sel.value).trim() : '';
    if(!id){
      sel && sel.focus();
      return false;
    }
    const base = "{{ url('/prefectures') }}";
    window.location.href = `${base}/${encodeURIComponent(id)}`;
    return false;
  }
</script>