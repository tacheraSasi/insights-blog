<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\Category;
use App\Models\Tag;
use App\Models\InsightView;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class InsightController extends Controller
{
    // Fetch insights for homepage
    public function home()
    {
        // Fetch insights with pagination (5 insights per page)
        $insights = Insight::orderBy('created_at', 'desc')->paginate(6);
        
        // Pass the insights to the view
        return view('home', compact('insights'));
    }

    // Fetch all insights
    public function index()
    {
        $insights = Insight::with('category', 'user', 'likes', 'comments', 'tags')->latest()->paginate(6);
        return view('home', compact('insights'));
    }

    // Show the form to create a new insight
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('insights.write', compact('categories', 'tags'));
    }

    // Store a new insight
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required', // Ensure this field exists in the form
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $slug = Str::slug($request->title);

        $insight = Insight::create([
            'title' => $request->title,
            'content' => $request->content, // Ensure this is being passed correctly
            'slug' => $slug,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(), // Use Auth::user() for the authenticated user ID
        ]);

        // Attach selected tags if any
        if ($request->has('tags') && is_array($request->tags)) {
            $insight->tags()->attach($request->tags);
        }

        return redirect()->route('insights.index')->with('success', 'Insight created successfully.');
    }

    // Show a specific insight
    public function show(Request $request, $slug)
    {
        $insight = Insight::where('slug', $slug)->with('category', 'user', 'comments', 'likes', 'tags')->firstOrFail();
        
        // Track view
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $userId = Auth::id();
        
        // Only track if this IP hasn't viewed this insight in the last 24 hours
        $existingView = InsightView::where('insight_id', $insight->id)
                                  ->where('ip_address', $ipAddress)
                                  ->where('created_at', '>=', now()->subDay())
                                  ->first();
        
        if (!$existingView) {
            InsightView::create([
                'insight_id' => $insight->id,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'user_id' => $userId,
            ]);
        }
        
        return view('insights.show', compact('insight'));
    }

    // Show the form to edit an insight
    public function edit($id)
    {
        $insight = Insight::with('tags')->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('insights.edit', compact('insight', 'categories', 'tags'));
    }

    // Update an existing insight
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required', // Ensure this field exists in the form
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $insight = Insight::findOrFail($id);
        $slug = Str::slug($request->title);

        $insight->update([
            'title' => $request->title,
            'content' => $request->content, // Ensure this is being passed correctly
            'slug' => $slug,
            'category_id' => $request->category_id,
        ]);

        // Sync tags (this will remove old tags and add new ones)
        if ($request->has('tags') && is_array($request->tags)) {
            $insight->tags()->sync($request->tags);
        } else {
            // If no tags selected, remove all existing tags
            $insight->tags()->sync([]);
        }

        return redirect()->route('insights.index')->with('success', 'Insight updated successfully.');
    }

    // Delete an insight
    public function destroy($id)
    {
        $insight = Insight::findOrFail($id);
        if (Auth::user() != $insight->user){
            return redirect(request()->url());
        }
        $insight->delete();
        return redirect()->route('insights.index')->with('success', 'Insight deleted successfully.');
    }
}
