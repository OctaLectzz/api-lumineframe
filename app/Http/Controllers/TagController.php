<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();

        return TagResource::collection($tags);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:tags|max:50',
            'description' => 'nullable|string|max:255'
        ]);

        $tag = Tag::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Tag Created Successfully',
            'data' => new TagResource($tag)
        ]);
    }

    public function show(Tag $tag)
    {
        return response()->json([
            'data' => new TagResource($tag)
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);

        $tag->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Tag Edited Successfully',
            'data' => new TagResource($tag)
        ]);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tag Deleted Successfully'
        ]);
    }
}
