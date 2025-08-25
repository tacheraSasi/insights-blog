<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Insight;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function store(Request $request, Insight $insight)
    {
        $user = auth()->user();
        
        $existingBookmark = Bookmark::where('user_id', $user->id)
                                  ->where('insight_id', $insight->id)
                                  ->first();
        
        if ($existingBookmark) {
            $existingBookmark->delete();
            $isBookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'insight_id' => $insight->id,
            ]);
            $isBookmarked = true;
        }
        
        return response()->json([
            'isBookmarked' => $isBookmarked,
            'bookmarksCount' => $insight->bookmarks()->count(),
        ]);
    }
}