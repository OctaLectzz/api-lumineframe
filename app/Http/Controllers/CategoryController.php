<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
            'name' => 'required|string|unique:categories|max:50',
            'description' => 'nullable|string|max:255'
        ]);

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
