<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreStarRequest;
use App\Http\Requests\V1\UpdateStarRequest;
use App\Http\Resources\V1\StarCollection;
use App\Http\Resources\V1\StarResource;
use App\Models\Star;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = Star::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
            });
        }

        $stars = $query->orderBy('first_name')->orderBy('last_name')->get();

        return new StarCollection($stars);
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
