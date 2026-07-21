<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);

        return view('admin.articles.index',compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        Article::create($request->all());

        return redirect()
            ->route('articles.index')
            ->with('success','Article created.');
    }

    public function edit(Article $article)
    {
        return view(
            'admin.articles.edit',
            compact('article')
        );
    }

    public function update(Request $request,Article $article)
    {
        $article->update($request->all());

        return redirect()
            ->route('articles.index')
            ->with('success','Article updated.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return back()
            ->with('success','Article deleted.');
    }
}
