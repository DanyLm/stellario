<?php

namespace App\Observers;

use App\Models\Star;
use App\Http\Services\FileService;

class StarObserver
{

    /**
     * seeders
     *
     * @var array
     */
    public array $seeders = [
        'public/star.png',
        'public/face-1.png',
        'public/face-2.png',
        'public/face-3.png',
        'public/face-4.png',
        'public/face-5.png',
    ];

    /**
     * Handle the Star "created" event.
     */
    public function created(Star $star): void
    {
        $face = json_decode($star->face);
        if (!$face || !in_array($face->origin, $this->seeders)) {
            $path = 'public/star.png';
            $star->update(['face' => FileService::jsonMetadata($path)]);
        }
    }

    /**
     * Handle the Star before "updated" event.
     */
    public function updating(Star $star): void
    {
        $_star = Star::find($star->id);
        $face = json_decode($_star->face);

        $face && $this->deleteSafelyFace($face->origin);
    }

    /**
     * Handle the Star "deleted" event.
     */
    public function deleted(Star $star): void
    {
        $face = json_decode($star->face);
        $face && $this->deleteSafelyFace($face->origin);
    }

    /**
     * deleteSafelyFace
     *
     * @param  mixed $face
     * @return void
     */
    public function deleteSafelyFace(string $face): void
    {
        // Delete old image if it's not the defaults seeders data
        if (!in_array($face, $this->seeders)) {
            FileService::delete($face);
        }
    }
}
