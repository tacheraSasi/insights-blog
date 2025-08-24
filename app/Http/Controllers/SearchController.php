<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');
        $tag = $request->get('tag');
        
        $insights = Insight::with('category', 'user', 'likes', 'comments', 'tags')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                });
            })
            ->when($category, function ($queryBuilder) use ($category) {
                return $queryBuilder->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->when($tag, function ($queryBuilder) use ($tag) {
                return $queryBuilder->whereHas('tags', function ($q) use ($tag) {
                    $q->where('slug', $tag);
                });
            })
            ->latest()
            ->paginate(12);

        $categories = Category::all();
        $tags = Tag::all();

        return view('search.index', compact('insights', 'categories', 'tags', 'query', 'category', 'tag'));
    }

    public function api(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $insights = Insight::select('id', 'title', 'slug')
            ->where('title', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($insights);
    }
}
