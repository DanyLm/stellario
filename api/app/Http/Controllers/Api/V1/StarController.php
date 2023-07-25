<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreStarRequest;
use App\Http\Requests\V1\UpdateFaceStarRequest;
use App\Http\Requests\V1\UpdateStarRequest;
use App\Http\Resources\V1\StarCollection;
use App\Http\Resources\V1\StarResource;
use App\Http\Services\FileService;
use App\Models\Star;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

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
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', '%' . $searchTerm . '%')
                    ->orWhere(DB::raw('CONCAT(last_name, " ", first_name)'), 'like', '%' . $searchTerm . '%')
                    ->orWhere('popularity', $searchTerm);
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
        $data = $request->validated();

        // if (!isset($data['face'])) {
        //     $path = 'public/star.png';
        //     $data['face'] = FileService::jsonMetadata($path);
        // }

        return new StarResource(Star::create($data));
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
        $star->update($request->validated());
        return new StarResource($star);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Star $star
     * @return JsonResponse
     */
    public function destroy(Star $star): JsonResponse
    {
        $star->delete();
        return response()->json([
            'toast' => [
                'message' => 'Star supprimée aves succès',
                'type' => 'success'
            ]
        ]);
    }

    /**
     * updateFace
     *
     * @param  UpdateFaceStarRequest $request
     * @param  Star $star
     * @return JsonResponse
     */
    public function updateFace(UpdateFaceStarRequest $request, Star $star): JsonResponse
    {
        $file = $request->validated()['image'];

        try {
            $path = FileService::save($file);
            $star->update([
                'face' => FileService::jsonMetadata($path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'toast' => [
                    'message' => $e->getMessage(),
                    'type' => 'error'
                ]
            ], 500);
        }

        return response()->json(['toast' => [
            'message' => 'Photo sauvegardée avec succès',
            'type' => 'success'
        ]]);
    }
}
