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

/**
 * @group Stars
 */
class StarController extends Controller
{
    /**
     * Get stars
     *
     * ```StarController::class```
     *
     * @queryParam search string Input search, can be first name, last name, both or popularity. Example: dany bitard
     *
     * @param  Request $request
     * @return ResourceCollection
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
     * Store star
     *
     * ```StarController::class```
     *
     * @bodyParam first_name string required First name of the star. Example: Dany
     * @bodyParam last_name string required Last name of the star. Example: Bitard
     * @bodyParam popularity int required Popularity of the star ```1 to 99```. Example: 69
     * @bodyParam description string required Description of the star. Example:
     *
     * @param  StoreStarRequest $request
     * @return JsonResource
     */
    public function store(StoreStarRequest $request): JsonResource
    {
        $data = $request->validated();
        return new StarResource(Star::create($data));
    }


    /**
     * Get star
     *
     * ```StarController::class```
     *
     * @pathParam star int required ID of the star. Example: 1
     *
     * @param  Star $star
     * @return JsonResource
     */
    public function show(Star $star): JsonResource
    {
        return new StarResource($star);
    }

    /**
     * Update star
     *
     * ```StarController::class```
     *
     * @pathParam star int required ID of the star. Example: 1
     * @bodyParam first_name string required First name of the star. Example: Dany
     * @bodyParam last_name string required Last name of the star. Example: Bitard
     * @bodyParam popularity int required Popularity of the star ```1 to 99```. Example: 69
     * @bodyParam description string required Description of the star. Example:
     *
     * @param  UpdateStarRequest $request
     * @param  Star $star
     * @return JsonResource
     */
    public function update(UpdateStarRequest $request, Star $star): JsonResource
    {
        $star->update($request->validated());
        return new StarResource($star);
    }


    /**
     * Remove star
     *
     * ```StarController::class```
     *
     * @pathParam star int required ID of the star. Example: 1
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
      * Update face's star
     *
     * ```StarController::class```
     *
     * @pathParam star int required ID of the star. Example: 1
     * @bodyParam image image required Face image of the star. Example:
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
