<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreStarRequest;
use App\Http\Requests\V1\UpdateStarRequest;
use App\Http\Resources\V1\StarCollection;
use App\Http\Resources\V1\StarResource;
use App\Models\Star;
use Illuminate\Http\Resources\Json\JsonResource;

class StarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new StarCollection(Star::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStarRequest $request)
    {
        return new StarResource(Star::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Star $star): JsonResource
    {
        return new StarResource($star);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStarRequest $request, Star $star)
    {
        return new StarResource($star->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Star $star)
    {
        $star->delete();
        return response()->json("$star->first_name $star->last_name deleted successfully");
    }
}
