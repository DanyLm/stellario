<?php

namespace App\Observers;

use App\Models\Star;
use App\Http\Services\FileService;

class StarObserver
{
    /**
     * Handle the Star "created" event.
     */
    public function created(Star $star): void
    {
        $path = 'public/star.png';
        $star->update(['face' => FileService::jsonMetadata($path)]);
    }

    /**
     * Handle the Star before "updated" event.
     */
    public function updating(Star $star): void
    {
        $_star = Star::find($star->id);
        $face = json_decode($_star->face);
        // Delete old image if it's not the default one
        if ($face->origin != 'public/star.png') {
            FileService::delete($face->origin);
        }
    }

    /**
     * Handle the Star "deleted" event.
     */
    public function deleted(Star $star): void
    {
        $face = json_decode($star->face);
        // Delete old image if it's not the default one
        if ($face->origin != 'public/star.png') {
            FileService::delete($face->origin);
        }
    }
}
