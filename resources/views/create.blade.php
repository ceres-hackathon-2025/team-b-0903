<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <title>口コミ投稿</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root{
        --base-rgb: 234,206,202;
        --base: rgb(var(--base-rgb));
        --base-strong: rgb(199,149,141);
        --bg: #fffaf9;
        --text: #2b2726;
        --muted: #6b6462;
        --card: #ffffff;
        --ring: rgba(var(--base-rgb), .55);
        --shadow: 0 12px 30px rgba(0,0,0,.08);
        --radius: 14px;
    }

    /* はみ出し抑止の基本 */
    *, *::before, *::after { box-sizing: border-box; }

    html, body {
        margin: 0;
        padding: 0;
        font-family: system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans JP", sans-serif;
        color: var(--text);
        background:
        radial-gradient(1200px 600px at 80% -10%, rgba(var(--base-rgb), .20), transparent 65%),
        radial-gradient(900px 500px at -10% 10%, rgba(var(--base-rgb), .15), transparent 60%),
        var(--bg);
    }

    .wrap { max-width: 720px; margin: 4rem auto; padding: 0 1rem; }

    .card {
        background: var(--card);
        border-radius: var(--radius);
        overflow: clip; /* clipが無ければ hidden でも可 */
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,.04);
        background-clip: padding-box;
    }

    .card-header {
        padding: 1.25rem 1.25rem 0.75rem;
        background: linear-gradient(180deg, rgba(var(--base-rgb), .18), rgba(var(--base-rgb), .08));
        /* border-bottom は角で伸びて見えることがあるため inset シャドウに */
        box-shadow: inset 0 -1px rgba(0,0,0,.06);
    }
    .card-header h1 { margin: 0; font-size: 1.5rem; letter-spacing: .02em; }
    .card-header p  { margin: .35rem 0 0; color: var(--muted); font-size: .9rem; }

    .card-body { padding: 1.25rem; }
    .card-footer { padding: 1rem 1.25rem 1.25rem; display: flex; gap: .75rem; justify-content: flex-end; align-items: center; }

    .msg { margin: .75rem 0 0; padding: .75rem 1rem; border-radius: 10px; font-size: .95rem; }
    .msg-ok { background: rgba(46,160,67,.08); border: 1px solid rgba(46,160,67,.25); color: #226a35; }
    .msg-err{ background: rgba(220,38,38,.08); border: 1px solid rgba(220,38,38,.22); color: #7a1d1d; }

    .field { margin: 1rem 0 1.1rem; }
    .label { display: flex; align-items: center; gap: .5rem; font-weight: 600; font-size: .95rem; margin-bottom: .4rem; }
    .hint  { color: var(--muted); font-size: .82rem; margin-left: .25rem; }

    input[type="text"], textarea, select {
        width: 100%;
        border: 1px solid rgba(0,0,0,.12);
        border-radius: 12px;
        padding: .8rem .95rem;
        font-size: .95rem;
        background: #fff;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }

    /* フォーカスリングが外に出ないよう inset に変更 */
    input[type="text"]:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: var(--base-strong);
        box-shadow: inset 0 0 0 3px rgba(var(--base-rgb), .18);
        background: #fff;
    }

    textarea { min-height: 140px; line-height: 1.65; resize: vertical; }

    .stars { display: flex; gap: .15rem; align-items: center; user-select: none; }
    .star-btn {
        appearance: none; border: none; background: transparent; cursor: pointer;
        font-size: 1.6rem; line-height: 1; padding: .2rem .28rem; border-radius: 10px;
        transition: transform .08s ease, background .15s ease;
        color: #d8c1bd;
    }
    .star-btn:hover { transform: translateY(-1px) scale(1.04); background: rgba(var(--base-rgb), .18); }
    .star-btn.active { color: var(--base-strong); }
    .rating-inline { color: var(--muted); font-size: .9rem; margin-left: .4rem; }

    .row-2col { display: grid; grid-template-columns: 1fr; gap: 1rem; }
    @media (min-width: 720px) { .row-2col { grid-template-columns: 1fr 1fr; } }

    .btn {
        appearance: none; border: 0; cursor: pointer;
        padding: .8rem 1.1rem; border-radius: 12px; font-weight: 700;
        transition: transform .06s ease, filter .15s ease, box-shadow .15s ease;
    }
    .btn-primary {
        background: linear-gradient(180deg, var(--base), var(--base-strong));
        color: #fff;
        box-shadow: 0 6px 16px rgba(var(--base-rgb), .45);
    }
    .btn-primary:hover { filter: brightness(1.05); }
    .btn:active { transform: translateY(1px); }
    .btn-ghost {
        background: transparent; color: var(--base-strong);
        border: 1px solid rgba(var(--base-rgb), .55);
    }

    .note { color: var(--muted); font-size: .82rem; margin-top: .25rem; }

    .is-error {
        border-color: #dc2626 !important;
        box-shadow: inset 0 0 0 3px rgba(220,38,38,.18) !important;
    }
    </style>

</head>
<body>
    {{-- ヘッダー呼び出し --}}
  @include('partials.header')
  <div class="wrap">
    <div class="card">
      <div class="card-header">
        <h1>口コミを投稿</h1>
        <p>デートに役立つリアルな情報を共有しましょう。</p>

        {{-- 受け付けメッセージ（任意） --}}
        @if (session('status'))
          <div class="msg msg-ok">{{ session('status') }}</div>
        @endif

        {{-- バリデーションエラー（任意） --}}
        @if ($errors->any())
          <div class="msg msg-err">
            <ul style="margin: .4rem 0 .2rem .8rem; padding: 0;">
              @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>

      <div class="card-body">

      
        <form method="GET" action="#">

          <div class="field">
            <label class="label">スポット名 <span class="hint">例: 代々木公園、チームラボ…</span></label>
            <input type="text" name="spot_name" value="{{ old('spot_name') }}" placeholder="スポット名を入力" />
          </div>

          <div class="row-2col">
            <div class="field">
              <label class="label">評価（1〜5）</label>

              {{-- 視覚的なスターUI（セレクトと同期） --}}
              <div class="stars" aria-label="評価（スター）">
                <button type="button" class="star-btn" data-value="1" aria-label="1点">★</button>
                <button type="button" class="star-btn" data-value="2" aria-label="2点">★</button>
                <button type="button" class="star-btn" data-value="3" aria-label="3点">★</button>
                <button type="button" class="star-btn" data-value="4" aria-label="4点">★</button>
                <button type="button" class="star-btn" data-value="5" aria-label="5点">★</button>
                <span class="rating-inline" id="ratingLabel">未選択</span>
              </div>

              {{-- 実値は従来のセレクトで保持（アクセシブル＆ノーフレームワーク） --}}
              <div style="margin-top:.5rem">
                <select name="rating" id="ratingSelect" aria-label="評価（セレクト）">
                  <option value="">選択してください</option>
                  @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }}</option>
                  @endfor
                </select>
                <div class="note">※ 星かセレクト、どちらで操作してもOKです。</div>
              </div>
            </div>

            <div class="field">
              <label class="label">訪問日 <span class="hint">任意</span></label>
              <input type="date" name="visited_at" value="{{ old('visited_at') }}" />
            </div>
          </div>

          <div class="field">
            <label class="label">本文</label>
            <textarea name="body" rows="6" placeholder="例）夕暮れの時間帯がおすすめ。ベンチが多く会話しやすい雰囲気。近くのカフェも比較的空いていました。">{{ old('body') }}</textarea>
            <div class="note">具体的に書くほど他の人の参考になります（雰囲気・混雑・音量・雨の日可否など）。</div>
          </div>

          <div class="card-footer">
            <button type="reset" class="btn btn-ghost">リセット</button>
            <button type="submit" class="btn btn-primary">送信</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // ★ スターUIと<select>の同期（素のJS）
    (function() {
      const select = document.getElementById('ratingSelect');
      const label = document.getElementById('ratingLabel');
      const stars = Array.from(document.querySelectorAll('.star-btn'));

      function render(val) {
        const n = Number(val) || 0;
        stars.forEach((btn, idx) => btn.classList.toggle('active', idx < n));
        label.textContent = n ? `${n}.0 / 5` : '未選択';
      }

      // 星をクリック → selectに反映
      stars.forEach((btn) => {
        btn.addEventListener('click', () => {
          select.value = btn.dataset.value;
          render(select.value);
        });
      });

      // セレクト変更 → 星に反映
      select.addEventListener('change', () => render(select.value));

      // 初期表示（old()などを反映）
      render(select.value);
    })();
  </script>
</body>
</html>
