<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    // 投稿一覧表示
    $posts = \App\Models\Post::with(['user', 'place', 'like'])->orderBy('created_at', 'desc')->get();
    return view('posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    // 投稿作成フォーム表示
    return view('create');
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
            'recommend' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validated['like_count'] = 0;

        // 画像保存処理
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image_path'] = $imagePath;
        }

        $post = \App\Models\Post::create($validated);
        return redirect()->route('posts.show', $post->id)->with('success', '投稿を作成しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    // 投稿詳細表示
    $post = \App\Models\Post::with(['user', 'place', 'like'])->findOrFail($id);
    return view('posts', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    // 投稿編集フォーム表示
    $post = \App\Models\Post::findOrFail($id);
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
        $post = \App\Models\Post::findOrFail($id);
        $post->update($validated);
        return redirect()->route('posts.show', $post->id)->with('success', '投稿を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 投稿削除
        $post = \App\Models\Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', '投稿を削除しました');
    }

    
}
