<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InsightController extends Controller
{
    public function home(){
        // Fetch insights with pagination (5 insights per page)
        $insights = Insight::orderBy('created_at', 'desc')->paginate(5);
        // dd($insights)

        // Pass the insights to the view
        return view('home', compact('insights'));
    }
    public function index()
    {
        $insights = Insight::with('category', 'user', 'likes', 'comments')->latest()->paginate(10);
        return view('insights.index', compact('insights'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('insights.write', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $slug = Str::slug($request->title);

        Insight::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('home')->with('success', 'Insight created successfully.');
    }

    public function show($slug)
    {
        $insight = Insight::where('slug', $slug)->with('category', 'user', 'comments', 'likes')->firstOrFail();
        return view('insights.show', compact('insight'));
    }

    public function edit($id)
    {
        $insight = Insight::findOrFail($id);
        $categories = Category::all();
        return view('insights.edit', compact('insight', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $insight = Insight::findOrFail($id);
        $slug = Str::slug($request->title);

        $insight->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('insights.index')->with('success', 'Insight updated successfully.');
    }

    public function destroy($id)
    {
        $insight = Insight::findOrFail($id);
        $insight->delete();
        return redirect()->route('insights.index')->with('success', 'Insight deleted successfully.');
    }
}
