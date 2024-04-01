<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Resources\PhotoResource;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();

        return PhotoResource::collection($photos);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,name',
        ]);
        $data['user_id'] = auth()->id();

        // Image
        if ($request->hasFile('image')) {
            $imageName = time() . '-' . auth()->id() . '_' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $photo = Photo::create($data);
        $photo->tags()->attach($request->tags);

        return response()->json([
            'status' => 'Success',
            'message' => 'Photo Created Successfully',
            'data' => new PhotoResource($photo)
        ]);
    }

    public function show(Photo $photo)
    {
        return response()->json([
            'data' => new PhotoResource($photo)
        ]);
    }

    public function update(Request $request, Photo $photo)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'required|exists:tags,name',
        ]);
        $data['user_id'] = auth()->id();

        // Image
        if ($request->hasFile('image')) {
            if ($photo->image && file_exists(public_path('images/' . $photo->image))) {
                unlink(public_path('images/' . $photo->image));
            }

            $imageName = time() . '-' . auth()->id() . '_' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $photo->tags()->sync($request->tags);
        $photo->update($data);

        return response()->json([
            'status' => 'Success',
            'message' => 'Photo Edited Successfully',
            'data' => new PhotoResource($photo)
        ]);
    }

    public function destroy(Photo $photo)
    {
        if ($photo->image && File::exists(public_path('images/' . $photo->image))) {
            File::delete(public_path('images/' . $photo->image));
        }

        $photo->detach();
        $photo->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Photo Deleted Successfully'
        ]);
    }
}