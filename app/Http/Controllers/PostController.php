<?php

namespace App\Http\Controllers;

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
            'recommend' => 'nullable|boolean',
        ]);
        $post->update($validated);
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
            // $placeが存在しない場合は404を返す
        $placeModel = Place::findOrFail($place);
        $posts = Post::where('place_id', $placeModel->id)
            ->with(['user', 'place', 'like'])
            ->orderByDesc('created_at')
            ->get();
            
        return view('posts', [
            'posts' => $posts,
            'place_id' => $placeModel->id,
            'place_name' => $placeModel->name
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
    // ...existing code...


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
            'recommend' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validated['like_count'] = 0;

        // 画像保存処理
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image_path'] = $imagePath;
        }

        $post = Post::create($validated);
        return redirect()->route('posts.show', $post->id)->with('success', '投稿を作成しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 投稿詳細表示
        $post = Post::with(['user', 'place', 'like'])->findOrFail($id);
        return view('posts', compact('post'));
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
}
