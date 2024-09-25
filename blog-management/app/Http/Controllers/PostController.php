<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $posts = Post::all();
            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('featured_image', function ($row) {
                    $imageUrl = asset('all_image/posts/' . $row->featured_image); // Adjust the path as needed
                    return '<img src="' . $imageUrl . '" alt="Image" style="max-width:100px; max-height:100px;">';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : 'N/A'; // Show category name or 'N/A' if not exists
                })

                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="dropdown action-dropdown">
                    <a href="javascript:void(0);" class="link-dot dropdown-toggle" id="income_dropdown"data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="income_dropdown">
                    <a id="ShowModal" href="javascript:void(0)" class="nav-link" data-ajax-popup="false" data-url="' . route('posts.show', $row->id) . '">Show</a>
                    <a id="EditPostModal" href="javascript:void(0)" class="nav-link" data-ajax-popup="false" data-url="' . route('posts.edit', $row->id) . '">Edit</a>
                    <a href="javascript:void(0)" class="delete nav-link" data-url="' . route('posts.destroy', $row->id) . '">Delete</a>
                    </div>
                  </div>';
                    return $actionBtn;
                })

                ->rawColumns(['featured_image', 'category_name', 'action'])
                ->make(true);
        }

        return view('admin.posts.index');
    }



    public function create()
    {
        $categories = Category::get();
        return response()->json(view('admin.posts.create', compact('categories'))->render());
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'publication_date' => 'required|date',
            'featured_image' => 'nullable|image|max:2048',
        ]);


        $categories = new Post();
        $categories->category_id = $request->category_id;
        $categories->title = $request->title;
        $categories->content = $request->content;
        $categories->publication_date = $request->publication_date;


        if ($request->hasFile('featured_image')) {
            $faq_image = $request->file('featured_image');
            $image = time() . '.' . $faq_image->getClientOriginalExtension();
            $destinationPath = public_path('/all_image/posts');
            $faq_image->move($destinationPath, $image);
            $categories->featured_image = $image;
        }

        $categories->save();
        return response()->json(['success' => "Post created successfully"]);
    }


    public function edit(Post $post)
    {
        $categories = Category::get();
        return response()->json(view('admin.posts.edit', compact('post', 'categories'))->render());
    }

    public function show(Post $post)
    {
        return response()->json(view('admin.posts.show', compact('post'))->render());
    }


    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'publication_date' => 'required|date',
            'featured_image' => 'nullable|image|max:2048',
        ]);
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->publication_date = $request->publication_date;


        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                $oldImagePath = public_path('all_image/posts/' . $post->featured_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            $faq_image = $request->file('featured_image');
            $image = time() . '.' . $faq_image->getClientOriginalExtension();
            $destinationPath = public_path('/all_image/posts');
            $faq_image->move($destinationPath, $image);
            $post->featured_image = $image;
        }

        $post->update();
        return response()->json(['success' => "Post Updated successfully"]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['status' => 1, 'message' => "delete"]);
    }
}
