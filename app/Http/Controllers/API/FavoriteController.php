<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        try {
            // Pour le moment, retourner une liste vide
            return response()->json([
                'status' => true,
                'data' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function toggle(Event $event)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = auth()->user();
        
        if ($event->likes()->where('user_id', $user->id)->exists()) {
            $event->likes()->where('user_id', $user->id)->delete();
            $message = 'Event removed from favorites';
        } else {
            $event->likes()->create(['user_id' => $user->id]);
            $message = 'Event added to favorites';
        }

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
