<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // クエリが空の場合、リダイレクトまたはエラーメッセージを表示
        if (empty($query)) {
            return redirect()->back()->with('error', '検索クエリを入力してください。');
        }

        // 検索ロジック（例: Postモデルでタイトルと内容を検索）
        $places = Place::where('name', 'like', '%' . $query . '%')
            ->get();

        // 検索結果をビューに渡す
        return view('search.results', compact('places', 'query'));
    }
}
