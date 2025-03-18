<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $blogs = Blog::with(['user.organizer', 'category', 'likes', 'comments', 'views'])
            ->latest()
            ->paginate(10);

        $categories = Category::withCount('blogs')
            ->whereHas('blogs')
            ->get();

        $popularBlogs = Blog::withCount('views')
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();

        return view('blogs.index', compact('blogs', 'categories', 'popularBlogs'));
    }

    public function show(Blog $blog)
    {
        $blog->views()->create([
            'user_id' => auth()->id()
        ]);

        $blog->load(['user.organizer', 'category', 'comments.user', 'likes']);

        $similarBlogs = Blog::where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->limit(3)
            ->get();

        $categories = Category::withCount('blogs')
            ->whereHas('blogs')
            ->get();

        return view('blogs.show', compact('blog', 'similarBlogs', 'categories'));
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create($validated);

        return redirect()->route('blogs.show', $blog)
            ->with('success', 'Blog créé avec succès !');
    }

    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return redirect()->route('blogs.show', $blog)
            ->with('success', 'Blog mis à jour avec succès !');
    }

    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog supprimé avec succès.');
    }

    public function byCategory(Category $category)
    {
        $blogs = $category->blogs()
            ->with(['user.organizer', 'likes', 'comments', 'views'])
            ->latest()
            ->paginate(10);

        $categories = Category::withCount('blogs')
            ->whereHas('blogs')
            ->get();

        $popularBlogs = Blog::withCount('views')
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();

        return view('blogs.index', compact('blogs', 'categories', 'popularBlogs', 'category'));
    }

    public function like(Blog $blog)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour aimer un article'
            ], 401);
        }

        $like = $blog->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $action = 'unliked';
        } else {
            $blog->likes()->create([
                'user_id' => $user->id
            ]);
            $action = 'liked';
        }

        return response()->json([
            'success' => true,
            'action' => $action,
            'likesCount' => $blog->likes()->count()
        ]);
    }

    public function comment(Request $request, Blog $blog)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = $blog->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'commentsCount' => $blog->comments()->count()
        ]);
    }

    public function share(Blog $blog)
    {
        // Générer l'URL de partage
        $shareUrl = route('blogs.show', $blog);

        return response()->json([
            'success' => true,
            'shareUrl' => $shareUrl,
            'title' => $blog->title
        ]);
    }
}
