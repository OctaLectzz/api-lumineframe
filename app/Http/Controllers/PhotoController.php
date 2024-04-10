<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'title' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:255'
        ]);
        $data['photo_number'] = str_pad(rand(1, 999999999), 9, '0', STR_PAD_LEFT);
        $data['user_id'] = auth()->id();

        // Image
        if ($request->hasFile('image')) {
            $imageName = time() . '-' . auth()->user()->username . '_' . $data['photo_number'] . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        // Tags
        if (!empty($data['tags'])) {
            $tagsToAttach = [];

            foreach ($data['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagsToAttach[] = $tag->id;
            }

            $photo = Photo::create($data);
            $photo->tags()->attach($tagsToAttach);
        } else {
            $photo = Photo::create($data);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Photo Created Successfully',
            'data' => new PhotoResource($photo)
        ]);
    }

    public function show($photo_number)
    {
        $photo = Photo::where('photo_number', $photo_number)->firstOrFail();

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
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:255'
        ]);
        $data['user_id'] = auth()->id();

        // Image
        if ($request->hasFile('image')) {
            if ($photo->image && file_exists(public_path('images/' . $photo->image))) {
                unlink(public_path('images/' . $photo->image));
            }

            $imageName = time() . '-' . auth()->user()->username . '_' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        // Tags
        if (!empty($data['tags'])) {
            $tagsToAttach = [];

            foreach ($data['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagsToAttach[] = $tag->id;
            }

            $photo->tags()->sync($tagsToAttach);
            $photo->update($data);
        } else {
            $photo->update($data);
        }

        return response()->json([
            'status' => 'success',
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
            'status' => 'success',
            'message' => 'Photo Deleted Successfully'
        ]);
    }
}
