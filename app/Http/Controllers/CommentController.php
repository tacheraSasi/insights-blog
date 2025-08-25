<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Insight;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $insightId)
    {
        $request->validate([
            'comment' => 'required',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => auth()->id(),
            'insight_id' => $insightId,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
