<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->get();

        return CommentResource::collection($comments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo_id' => 'required|exists:photos,id',
            'content' => 'required|string|max:255'
        ]);
        $data['user_id'] = auth()->id();

        $comment = Comment::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment Created Successfully',
            'data' => new CommentResource($comment)
        ]);
    }

    public function show(Comment $comment)
    {
        return response()->json([
            'data' => new CommentResource($comment)
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'photo_id' => 'required|exists:photos,id',
            'content' => 'required|string|max:255'
        ]);
        $data['user_id'] = auth()->id();

        $comment->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment Edited Successfully',
            'data' => new CommentResource($comment)
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment Deleted Successfully'
        ]);
    }
}
