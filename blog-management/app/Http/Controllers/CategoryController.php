<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $categories = Category::all();
            return DataTables::of($categories)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="dropdown action-dropdown">
                    <a href="javascript:void(0);" class="link-dot dropdown-toggle" id="income_dropdown"data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="income_dropdown">
                    <a id="ShowModal" href="javascript:void(0)" class="nav-link" data-ajax-popup="false" data-url="' . route('categories.show', $row->id) . '">Show</a>
                    <a id="EditCategoryModal" href="javascript:void(0)" class="nav-link" data-ajax-popup="false" data-url="' . route('categories.edit', $row->id) . '">Edit</a>
                    <a href="javascript:void(0)" class="delete nav-link" data-url="' . route('categories.destroy', $row->id) . '">Delete</a>
                    </div>
                  </div>';
                    return $actionBtn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.categories.index');
    }



    public function create()
    {
        return response()->json(view('admin.categories.create')->render());
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $categories = new Category();
        $categories->name = $request->name;
        $categories->save();
        return response()->json(['success' => "Category created successfully"]);
    }


    public function edit(Category $category)
    {
        return response()->json(view('admin.categories.edit', compact('category'))->render());
    }

    public function show(Category $category)
    {
        return response()->json(view('admin.categories.show', compact('category'))->render());
    }

    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $request->name;
        $category->update();
        return response()->json(['success' => "Category updated successfully"]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['status' => 1, 'message' => "delete"]);
    }
}
