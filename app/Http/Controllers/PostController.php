<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Place;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    // 投稿一覧表示
    $posts = Post::with(['user', 'place', 'like'])->orderBy('created_at', 'desc')->get();
    return view('posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($place_id)
    {
        // 投稿作成フォーム表示
        $place_name = Place::where('id', $place_id)->value("name");
        return view('create', compact('place_name', 'place_id'));
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
            'recommend' => 'nullable|integer',
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
    public function edit(string $id)
    {
    // 投稿編集フォーム表示
    $post = Post::findOrFail($id);
    return view('create', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 投稿更新
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'recommend' => 'nullable|boolean',
        ]);
    $post = Post::findOrFail($id);
        $post->update($validated);
        return redirect()->route('posts.show', $post->id)->with('success', '投稿を更新しました');
    }

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
