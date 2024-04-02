<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Resources\CollectionResource;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::latest()->get();

        return CollectionResource::collection($collections);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photos' => 'required|exists:photos,id',
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);
        $data['user_id'] = auth()->id();

        $collection = Collection::create($data);
        $collection->photos()->attach($request->photos);

        return response()->json([
            'status' => 'success',
            'message' => 'Collection Created Successfully',
            'data' => new CollectionResource($collection)
        ]);
    }

    public function show(Collection $collection)
    {
        return response()->json([
            'data' => new CollectionResource($collection)
        ]);
    }

    public function update(Request $request, Collection $collection)
    {
        $data = $request->validate([
            'photos' => 'required|exists:photos,id',
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);
        $data['user_id'] = auth()->id();

        $collection->photos()->sync($request->photos);
        $collection->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Collection Edited Successfully',
            'data' => new CollectionResource($collection)
        ]);
    }

    public function destroy(Collection $collection)
    {
        $collection->detach();
        $collection->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Collection Deleted Successfully'
        ]);
    }
}
