<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $posts = Blog::with(['user', 'category'])
                ->where('is_published', true)
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Articles récupérés avec succès',
                'data' => $posts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $post = Blog::with(['user', 'category'])
                ->where('is_published', true)
                ->whereNotNull('published_at')
                ->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Article récupéré avec succès',
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Article non trouvé',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
