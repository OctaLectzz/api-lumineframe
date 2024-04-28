<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Resources\LikeResource;
use App\Http\Resources\PhotoResource;

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

    public function userlike($id)
    {
        $likes = Like::with('photo')->where('user_id', $id)->get();

        $photos = [];
        foreach ($likes as $like) {
            $photos[] = $like->photo;
        }

        return PhotoResource::collection($photos);
    }

    public function like($id)
    {
        // Like Check
        $existingLike = Like::where('user_id', auth()->id())->where('photo_id', $id)->first();
        if ($existingLike) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already Liked this Photo'
            ], 403);
        }

        $like = Like::create([
            'user_id' => auth()->id(),
            'photo_id' => $id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Photo Liked Successfully',
            'data' => new LikeResource($like)
        ]);
    }

    public function dislike($id)
    {
        $like = Like::where([
            'user_id' => auth()->id(),
            'photo_id' => $id,
        ])->firstOrFail();

        $like->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Photo Unliked Successfully',
            'data' => new LikeResource($like)
        ]);
    }
}
