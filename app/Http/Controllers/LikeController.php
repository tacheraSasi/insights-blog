<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Insight;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, $insightId)
    {
        $insight = Insight::findOrFail($insightId);
        $like = $insight->likes()->where('user_id', auth()->id())->first();
        $isLiked = false;
        $message = '';

        if ($like) {
            $like->delete();
            $message = 'Like removed.';
            $isLiked = false;
        } else {
            $insight->likes()->create(['user_id' => auth()->id()]);
            $message = 'Liked.';
            $isLiked = true;
        }

        $likesCount = $insight->likes()->count();

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'isLiked' => $isLiked,
                'likesCount' => $likesCount,
                'message' => $message
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
