<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Resources\LikeResource;

class LikeController extends Controller
{
    public function index()
    {
        $likes = Like::latest()->get();

        return LikeResource::collection($likes);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo_id' => 'required|integer|exists:photos,id'
        ]);
        $data['user_id'] = auth()->id();

        $like = Like::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Like Created Successfully',
            'data' => new LikeResource($like)
        ]);
    }

    public function show(Like $like)
    {
        return response()->json([
            'data' => new LikeResource($like)
        ]);
    }

    public function update(Request $request, Like $like)
    {
        $data = $request->validate([
            'photo_id' => 'required|integer|exists:photos,id'
        ]);
        $data['user_id'] = auth()->id();

        $like->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Like Edited Successfully',
            'data' => new LikeResource($like)
        ]);
    }

    public function destroy(Like $like)
    {
        $like->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Like Deleted Successfully'
        ]);
    }

    public function like($id)
    {
        $photo = Photo::findOrFail($id);

        $like = $photo->likes()->create([
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Liked Successfully',
            'data' => new LikeResource($like)
        ]);
    }

    public function unlike($id)
    {
        $like = Like::where([
            'user_id' => auth()->id(),
            'photo_id' => $id,
        ])->firstOrFail();

        $like->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Unliked Successfully',
            'data' => new LikeResource($like)
        ]);
    }
}
