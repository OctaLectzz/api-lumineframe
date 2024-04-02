<?php

namespace App\Http\Controllers;

use App\Models\CollectionPhoto;
use Illuminate\Http\Request;
use App\Http\Resources\CollectionPhotoResource;

class CollectionPhotoController extends Controller
{
    public function index()
    {
        $collectionphotos = CollectionPhoto::latest()->get();

        return CollectionPhotoResource::collection($collectionphotos);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo_id' => 'required|integer|exists:photos,id',
            'collection_id' => 'required|integer|exists:collections,id'
        ]);
        $data['user_id'] = auth()->id();

        $collectionphoto = CollectionPhoto::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Collection Photo Created Successfully',
            'data' => new CollectionPhotoResource($collectionphoto)
        ]);
    }

    public function show(CollectionPhoto $collectionphoto)
    {
        return response()->json([
            'data' => new CollectionPhotoResource($collectionphoto)
        ]);
    }

    public function update(Request $request, CollectionPhoto $collectionphoto)
    {
        $data = $request->validate([
            'photo_id' => 'required|integer|exists:photos,id',
            'collection_id' => 'required|integer|exists:collections,id'
        ]);
        $data['user_id'] = auth()->id();

        $collectionphoto->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Collection Photo Edited Successfully',
            'data' => new CollectionPhotoResource($collectionphoto)
        ]);
    }

    public function destroy(CollectionPhoto $collectionphoto)
    {
        $collectionphoto->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Collection Photo Deleted Successfully'
        ]);
    }
}
