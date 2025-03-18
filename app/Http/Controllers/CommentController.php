<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        $blog->comments()->save($comment);

        return back()->with('success', 'Votre commentaire a été publié avec succès.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Le commentaire a été supprimé avec succès.');
    }
}
