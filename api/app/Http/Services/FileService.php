<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileService
{
    /**
     * metadata
     *
     * @param  string $path
     * @return string
     */
    public static function jsonMetadata(string $path): string
    {
        return json_encode([
            'origin' => $path,
            'path' => env('APP_URL') . Storage::url($path),
            'mime' => Storage::mimeType($path),
            'size' => Storage::size($path)
        ]);
    }

    /**
     * save
     *
     * @param  UploadedFile $file
     * @return string
     */
    public static function save(UploadedFile $file): string
    {
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        return Storage::putFileAs('public/images', $file, $name);
    }

    /**
     * delete
     *
     * @param  string $path
     * @return bool
     */
    public static function delete(string $path): bool
    {
        try {
            Storage::delete($path);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
