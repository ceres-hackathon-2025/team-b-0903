<?php

namespace App\Http\Controllers;
use App\Models\Prefecture;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Place;

class PostController extends Controller
{
    // 観光地ごとの投稿作成フォーム表示
    public function createByPlace($place)
    {
        // place_idを渡して投稿作成フォーム表示
        return view('create', ['place_id' => $place]);
    }



    // 投稿編集（投稿者のみ）
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        return view('create', compact('post'));
    }



    // 投稿更新（編集完了後は投稿詳細へリダイレクト）
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'recommend' => 'nullable|integer|min:1|max:5',
        ]);
        $post->update($validated);
        // 投稿更新後におすすめ度平均値を更新
        $this->updateRecommendAverageForPlace($post->place_id);
        return redirect()->route('posts.show', $post->id)->with('success', '投稿を更新しました');
    }

    /**タグごとの投稿一覧
    public function indexByTag($tag)
    {
        $posts = Post::whereHas('tags', function($q) use ($tag) {
            $q->where('name', $tag);
        })->with(['user', 'place', 'like', 'tags'])->orderBy('created_at', 'desc')->get();
        return view('posts', compact('posts', 'tag'));
    }
     */


    // 投稿一覧表示
    public function index()
    {
        $posts = Post::with(['user', 'place', 'like'])->orderBy('created_at', 'desc')->get();
        return view('posts', compact('posts'));
    }
        // 観光地ごとの投稿一覧（都道府県経由 or 直接）
        // 観光地ごとの投稿一覧（直接）

        public function indexByPlace($place)
        {
            $posts = Post::where('place_id', $place)->with(['user', 'place', 'like'])->orderBy('created_at', 'desc')->get();
            $prefectures = Prefecture::all();
            $place_name = Place::where('id', $place)->value('name');
            $place_imgpath = Place::where('id', $place)->value('img_path');
            $place_recommend_avg = Place::where('id', $place)->value('recommend_average');

            return view('posts', [
                'posts' => $posts,
                'place_id' => $place,
                'place_name' => $place_name,
                'place_img_path' => $place_imgpath,
                'prefectures' => $prefectures,
                'place_recommend_avg' => $place_recommend_avg
            ]);
        }
        // 都道府県ごとの観光地→投稿一覧
        public function indexByPlaceWithPrefecture($prefecture, $place)
        {
            $posts = Post::where('place_id', $place)->with(['user', 'place', 'like'])->orderBy('created_at', 'desc')->get();
            return view('posts', [
                'posts' => $posts,
                'place_id' => $place,
                'prefecture_id' => $prefecture
            ]);
        }
    /**
     * Show the form for creating a new resource.
     */
    public function create($place_id)
    {
        // 投稿作成フォーム表示
        $place_name = Place::where('id', $place_id)->value("name");
        $prefectures = Prefecture::all();
        $user_id = Auth::id();      
        return view('create', compact('place_name', 'place_id', 'user_id', 'prefectures'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 投稿保存＋画像アップロード
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'place_id' => 'required|exists:places,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'recommend' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validated['like_count'] = 0;
        // 画像保存処理
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image_path'] = $imagePath;
        }

        $post = Post::create($validated);
        // 投稿作成後におすすめ度平均値を更新
        $this->updateRecommendAverageForPlace($validated['place_id']);
        return redirect()->route('posts.show', $post->id)->with('success', '投稿を作成しました');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    // $post = Post::with(['user', 'place', 'like'])->findOrFail($id);
    // $prefectures = Prefecture::all();
    // return view('post', compact('post', 'prefectures'));
    // }
    public function show(string $id)
    {
        // 都道府県（ヘッダー用）
        $prefectures = \App\Models\Prefecture::all();

        // リレーションだけを eager load（user, place, like は Model のメソッド名）
        $post = \App\Models\Post::with(['user', 'place', 'like'])->findOrFail($id);

        // recommend(1-5) を ★★★☆☆ に整形
        $score = (int) ($post->recommend ?? 0);
        $score = max(0, min(5, $score));
        $stars = str_repeat('★', $score) . str_repeat('☆', 5 - $score);

        // 画像パス（image_path カラム想定。なければ noimage）
        $imagePath = $post->image_path
            ? asset('storage/' . ltrim($post->image_path, '/'))
            : asset('images/noimage.png');

        // ビュー向けペイロード
        $payload = [
            'title'      => (string) ($post->title ?? ''),
            'recommend'  => $stars,
            'text'       => (string) ($post->content ?? ''),
            'user'       => optional($post->user)->name ?? '名無し',   // ← user リレーション
            'place'      => optional($post->place)->name ?? '不明',     // ← place リレーション
            'date'       => optional($post->created_at)->format('Y年n月j日') ?? '',
            'image_path' => $imagePath,
            'count_like' => (int) ($post->like_count ?? $post->like()->count()),
        ];

        // Blade へ渡す
        return view('post', [
            'postPayload' => $payload,
            'prefectures' => $prefectures,
        ]);
    }

    

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 投稿削除
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', '投稿を削除しました');
    }


    private function recommendAverageByPlace($place_id)
    {
        $average = Post::where('place_id', $place_id)->avg('recommend');
        return $average;
    }

    // 指定したplaceの投稿数を返す
    private function postCount($place_id)
    {
        $count = Post::where('place_id', $place_id)->count();
        return $count;
    }

    /**
     * 全ての観光地ごとに投稿おすすめ度平均値を算出し、Placeテーブルに保存する
     */
    public function updateRecommendAverage()
    {
        $places = Place::all();
        foreach ($places as $place) {
            $average = Post::where('place_id', $place->id)->avg('recommend');
            $place->recommend_average = $average;
            $place->save();
        }
    }

    // 観光地ごとのおすすめ度平均値を更新（投稿がある場合は平均値、ない場合は初期値3）
    private function updateRecommendAverageForPlace($place_id)
    {
        $average = Post::where('place_id', $place_id)->avg('recommend');
        if ($average === null) {
            $average = 3;
        }
        
        $place = Place::find($place_id);
        if ($place) {
            $place->recommend_average = $average;
            $place->save();
        }
    }
}
