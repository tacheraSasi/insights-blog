<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Insight;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\InsightView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_insights' => Insight::count(),
            'total_comments' => Comment::count(),
            'total_likes' => Like::count(),
            'total_bookmarks' => Bookmark::count(),
            'total_views' => InsightView::count(),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
        ];

        // Recent activity
        $recent_insights = Insight::with('user', 'category')->latest()->limit(5)->get();
        $recent_comments = Comment::with('user', 'insight')->latest()->limit(5)->get();
        $recent_users = User::latest()->limit(5)->get();

        // Popular insights
        $popular_insights = Insight::withCount('likes', 'comments', 'views')
                                  ->orderByDesc('likes_count')
                                  ->limit(5)
                                  ->get();

        // Monthly stats
        $monthly_insights = Insight::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recent_insights', 
            'recent_comments', 
            'recent_users', 
            'popular_insights',
            'monthly_insights'
        ));
    }

    public function users()
    {
        $users = User::withCount('insights', 'comments', 'likes')
                    ->latest()
                    ->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    public function insights()
    {
        $insights = Insight::with('user', 'category')
                          ->withCount('likes', 'comments', 'views')
                          ->latest()
                          ->paginate(20);
        
        return view('admin.insights', compact('insights'));
    }

    public function categories()
    {
        $categories = Category::withCount('insights')->get();
        
        return view('admin.categories', compact('categories'));
    }

    public function tags()
    {
        $tags = Tag::withCount('insights')->get();
        
        return view('admin.tags', compact('tags'));
    }
}