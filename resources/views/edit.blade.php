<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <title>口コミ編集</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    /* create.blade.phpと同じCSSを流用 */
    :root{ --base-rgb: 234,206,202; --base: rgb(var(--base-rgb)); --base-strong: rgb(199,149,141); --bg: #fffaf9; --text:#2b2726; --muted:#6b6462; --card:#fff; --ring: rgba(var(--base-rgb), .55); --shadow: 0 12px 30px rgba(0,0,0,.08); --radius: 14px; }
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin:0; padding:0; font-family:system-ui,-apple-system,Segoe UI,Roboto,"Noto Sans JP",sans-serif; color:var(--text); background: radial-gradient(1200px 600px at 80% -10%, rgba(var(--base-rgb), .20), transparent 65%), radial-gradient(900px 500px at -10% 10%, rgba(var(--base-rgb), .15), transparent 60%), var(--bg); }
    .wrap { max-width: 720px; margin: 4rem auto; padding: 0 1rem; }
    .card { background:var(--card); border-radius:var(--radius); overflow:clip; box-shadow:var(--shadow); border:1px solid rgba(0,0,0,.04); }
    .card-header { padding:1.25rem 1.25rem .75rem; background:linear-gradient(180deg, rgba(var(--base-rgb), .18), rgba(var(--base-rgb), .08)); box-shadow: inset 0 -1px rgba(0,0,0,.06); }
    .card-header h1{ margin:0; font-size:1.5rem; letter-spacing:.02em }
    .card-header p{ margin:.35rem 0 0; color:var(--muted); font-size:.9rem }
    .card-body{ padding:1.25rem }
    .card-footer{ padding:1rem 1.25rem 1.25rem; display:flex; gap:.75rem; justify-content:flex-end; align-items:center }
    .msg{ margin:.75rem 0 0; padding:.75rem 1rem; border-radius:10px; font-size:.95rem }
    .msg-ok{ background:rgba(46,160,67,.08); border:1px solid rgba(46,160,67,.25); color:#226a35 }
    .msg-err{ background:rgba(220,38,38,.08); border:1px solid rgba(220,38,38,.22); color:#7a1d1d }
    .field{ margin:1rem 0 1.1rem }
    .label{ display:flex; align-items:center; gap:.5rem; font-weight:600; font-size:.95rem; margin-bottom:.4rem }
    .hint{ color:var(--muted); font-size:.82rem; margin-left:.25rem }
    input[type="text"], textarea, select{ width:100%; border:1px solid rgba(0,0,0,.12); border-radius:12px; padding:.8rem .95rem; font-size:.95rem; background:#fff; transition:border-color .15s, box-shadow .15s, background .15s; }
    input[type="text"]:focus, textarea:focus, select:focus{ outline:none; border-color:var(--base-strong); box-shadow: inset 0 0 0 3px rgba(var(--base-rgb), .18); }
    textarea{ min-height:140px; line-height:1.65; resize:vertical }
    .row-2col{ display:grid; grid-template-columns:1fr; gap:1rem }
    @media (min-width:720px){ .row-2col{ grid-template-columns:1fr 1fr } }
    .stars{ display:flex; gap:.15rem; align-items:center; user-select:none }
    .star-btn{ appearance:none; border:none; background:transparent; cursor:pointer; font-size:1.6rem; line-height:1; padding:.2rem .28rem; border-radius:10px; transition:transform .08s, background .15s; color:#d8c1bd }
    .star-btn:hover{ transform:translateY(-1px) scale(1.04); background:rgba(var(--base-rgb), .18) }
    .star-btn.active{ color:var(--base-strong) }
    .rating-inline{ color:var(--muted); font-size:.9rem; margin-left:.4rem }
    .btn{ appearance:none; border:0; cursor:pointer; padding:.8rem 1.1rem; border-radius:12px; font-weight:700; transition:transform .06s, filter .15s, box-shadow .15s }
    .btn-primary{ color:#fff; background:linear-gradient(180deg, var(--base), var(--base-strong)); box-shadow:0 6px 16px rgba(var(--base-rgb), .45) }
    .btn-primary:hover{ filter:brightness(1.05) }
    .btn:active{ transform:translateY(1px) }
    .btn-ghost{ background:transparent; color:var(--base-strong); border:1px solid rgba(var(--base-rgb), .55) }
    .readonly[readonly]{ background:#f8f6f5; color:var(--muted); }
    .uploader{ display:flex; align-items:center; justify-content:center; border:2px dashed rgba(0,0,0,.15); border-radius:12px; padding:1.25rem; background:#fff; cursor:pointer; text-align:center; color:var(--muted); transition:border-color .15s, box-shadow .15s, background .15s }
    .uploader:hover{ border-color:var(--base-strong); box-shadow: inset 0 0 0 3px rgba(var(--base-rgb), .12) }
    .uploader input{ display:none }
    .uploader-text{ font-weight:700; color:#5a453f }
    .thumbs{ display:grid; grid-template-columns:repeat(auto-fill, minmax(96px,1fr)); gap:.6rem; margin-top:.75rem }
    .thumb{ position:relative; border:1px solid rgba(0,0,0,.1); border-radius:10px; overflow:hidden; background:#fff; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center }
    .thumb img{ width:100%; height:100%; object-fit:cover; display:block }
    .thumb .size{ position:absolute; right:6px; bottom:6px; font-size:.72rem; background:rgba(0,0,0,.55); color:#fff; padding:.05rem .3rem; border-radius:6px }
  </style>
</head>
<body>
  @include('partials.header')
  <div class="wrap">
    <div class="card">
      <div class="card-header">
        <h1>口コミを編集</h1>
        <p>投稿内容を修正できます。</p>
        @if (session('status'))
          <div class="msg msg-ok">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
          <div class="msg msg-err">
            <ul style="margin:.4rem 0 .2rem .8rem; padding:0;">
              @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
      <div class="card-body">
        <form id="editForm" method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="user_id" value="{{ $post->user_id }}">
          <input type="hidden" name="place_id" value="{{ $post->place_id }}">
          <div class="field">
            <label class="label">タイトル</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" placeholder="タイトルを入力" required />
          </div>
          <div class="row-2col">
            <div class="field">
              <label class="label">場所</label>
              <input type="hidden" name="place_id" value="{{ $post->place_id }}">
              <input type="text" name="place_name" value="{{ $place_name ?? '' }}" placeholder="未選択" readonly class="readonly" required />
            </div>
            <div class="field" id="satisfactionField">
              <label class="label">満足度</label>
              <div class="stars" aria-label="満足度（スター）">
                @for ($i = 1; $i <= 5; $i++)
                  <button type="button" class="star-btn{{ $post->recommend >= $i ? ' active' : '' }}" data-value="{{ $i }}" aria-label="{{ $i }}点">★</button>
                @endfor
                <span class="rating-inline" id="ratingLabel">{{ $post->recommend ? $post->recommend . '.0 / 5' : '未選択' }}</span>
              </div>
              <input type="hidden" name="recommend" id="recommendInput" value="{{ old('recommend', $post->recommend) }}" required>
            </div>
          </div>
          <div class="field">
            <label class="label">本文</label>
            <textarea name="content" rows="6" placeholder="本文を入力">{{ old('content', $post->content) }}</textarea>
          </div>
          <div class="field">
            <label class="label">写真 <span class="hint">最大5枚・各2MBまで（JPG/PNG/WebP）</span></label>
            <label class="uploader">
              <input id="photos" type="file" name="image" accept="image/*" multiple>
              <span class="uploader-text">ドラッグ＆ドロップ、またはクリックして選択</span>
            </label>
            <div id="preview" class="thumbs"></div>
            {{-- 既存画像の表示（必要ならここに追加） --}}
          </div>
          <div id="formMsg" class="msg" style="display:none"></div>
          <div class="card-footer">
            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-ghost">詳細に戻る</a>
            <button type="reset" class="btn btn-ghost">リセット</button>
            <button id="submitBtn" type="submit" class="btn btn-primary">更新</button>
            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" style="display:inline; margin-left:10px;" onsubmit="return confirm('本当に削除しますか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-ghost" style="color:#d00; border-color:#d00;" onclick="return confirm('本当にいいですか？');">削除</button>
            </form>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    // ★ スターUIと<select>の同期（create.blade.phpと同じ）
    (function () {
      const field = document.getElementById('satisfactionField');
      if (!field) return;
      const input = document.getElementById('recommendInput');
      const label = field.querySelector('#ratingLabel');
      const stars = Array.from(field.querySelectorAll('.star-btn'));
      function render(val) {
        const n = Number(val) || 0;
        stars.forEach((btn, idx) => btn.classList.toggle('active', idx < n));
        label.textContent = n ? `${n}.0 / 5` : '未選択';
      }
      stars.forEach(btn => {
        btn.addEventListener('click', () => {
          input.value = btn.dataset.value;
          render(input.value);
        });
      });
      render(input.value);
    })();
    // 画像プレビュー
    (function(){
      const input = document.getElementById('photos');
      const preview = document.getElementById('preview');
      const MAX_FILES = 5, MAX_SIZE = 2*1024*1024;
      function fmt(n){ return (n/1024/1024).toFixed(2)+'MB'; }
      if (!input) return;
      input.addEventListener('change', () => {
        preview.innerHTML = '';
        const files = Array.from(input.files || []);
        if (files.length > MAX_FILES) { alert(`写真は最大 ${MAX_FILES} 枚までです。`); input.value=''; return; }
        files.forEach(f => {
          if (!/^image\//.test(f.type)) return;
          if (f.size > MAX_SIZE) {
            const warn = document.createElement('div'); warn.className='note'; warn.style.color='#7a1d1d';
            warn.textContent = `${f.name} は ${fmt(f.size)}（2MB超過）→ 送信できません`;
            preview.appendChild(warn); return;
          }
          const url = URL.createObjectURL(f);
          const card = document.createElement('div'); card.className='thumb';
          card.innerHTML = `<img src="${url}" alt=""><span class="size">${fmt(f.size)}</span>`;
          preview.appendChild(card);
        });
      });
    })();
  </script>
</body>
</html>
