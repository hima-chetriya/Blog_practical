<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'publication_date' => 'required|date',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $featuredImagePath = $request->file('featured_image') ? $request->file('featured_image')->store('images', 'public') : null;

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'publication_date' => $request->publication_date,
            'featured_image' => $featuredImagePath,
        ]);

        return response()->json($post);
    }



    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'publication_date' => 'required|date',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post = Post::findOrFail($id);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $featuredImagePath = $request->file('featured_image')->store('images', 'public');
        } else {
            $featuredImagePath = $post->featured_image;
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'publication_date' => $request->publication_date,
            'featured_image' => $featuredImagePath,
        ]);

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();
        return response()->json(['success' => 'Post deleted successfully.']);
    }

    public function list(Request $request)
    {
        $search = $request->search ?? "";

        $posts = Post::query();

        if (!empty($search)) {
            $posts->where("title", "LIKE", "%" . $search . "%");
            $posts->orWhere("content", "LIKE", "%" . $search . "%");
        }

        $posts = $posts->get();

        return response()->json(view('posts.list', ['posts' => $posts])->render());
    }
}
