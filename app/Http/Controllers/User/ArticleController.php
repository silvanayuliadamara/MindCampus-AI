<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        
        $query = Article::orderBy('created_at', 'desc');
        
        if ($category && $category !== 'All') {
            $query->where('category', $category);
        }
        
        $articles = $query->get();
        
        // Define all categories dynamically
        $categories = Article::select('category')->distinct()->pluck('category');
        
        return view('user.articles.index', compact('articles', 'categories', 'category'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Fetch recommendations (random 3 articles other than current one)
        $recommendations = Article::where('id', '!=', $article->id)
            ->inRandomOrder()
            ->take(3)
            ->get();
            
        return view('user.articles.show', compact('article', 'recommendations'));
    }
}
