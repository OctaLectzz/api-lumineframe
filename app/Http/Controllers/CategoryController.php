<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'name' => 'required|string|unique:categories|max:50',
            'description' => 'nullable|string|max:255'
        ]);
        $data['category_code'] = Str::random(10);

        // Image
        if ($request->hasFile('image')) {
            $imageName = time() . '-' . $data['category_code'] . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('categories'), $imageName);
            $data['image'] = $imageName;
        }

        $category = Category::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Category Created Successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    public function show(Category $category)
    {
        return response()->json([
            'data' => new CategoryResource($category)
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);

        // Image
        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('categories/' . $category->image))) {
                unlink(public_path('categories/' . $category->image));
            }

            $imageName = time() . '-' . $data['category_code'] . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('categories'), $imageName);
            $data['image'] = $imageName;
        }

        $category->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Category Edited Successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category Deleted Successfully'
        ]);
    }
}
