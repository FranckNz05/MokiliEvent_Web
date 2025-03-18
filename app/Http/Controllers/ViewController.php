<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Blog;
use App\Models\Category;

class ViewController extends Controller
{
    public function increment($id, $type)
    {
        // Vérifiez si c'est un événement ou un blog
        if ($type === 'event') {
            $viewable = Event::findOrFail($id);
        } else {
            $viewable = Blog::findOrFail($id);
        }

        // Incrémentez le compteur de vues
        $viewable->increment('views_count');

        return response()->json(['message' => 'Vue ajoutée avec succès.'], 200);
    }
}
