<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Event;
use App\Models\Blog;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validation de la requête
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Vérifiez si c'est un événement ou un blog
        if ($request->input('likeable_type') === 'event') {
            $likeable = Event::findOrFail($id);
        } else {
            $likeable = Blog::findOrFail($id);
        }

        // Créez le like
        $like = new Like();
        $like->user_id = $request->input('user_id');
        $like->likeable()->associate($likeable);
        $like->save();

        return response()->json(['message' => 'Like ajouté avec succès.'], 201);
    }
}
