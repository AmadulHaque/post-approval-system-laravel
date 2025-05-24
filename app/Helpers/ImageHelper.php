<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    public static function uploadImage($file, $directory = 'images'): ?array
    {
        try {
            // Store original image
            $originalPath = $file->store("public/{$directory}");
            $originalPath = str_replace('public/', '', $originalPath);

            // Create thumbnail
            $thumbnail = Image::make($file)->fit(300, 200);
            $thumbnailPath = "public/thumbnails/" . basename($originalPath);
            Storage::put($thumbnailPath, $thumbnail->encode());
            $thumbnailPath = str_replace('public/', '', $thumbnailPath);

            return [
                'original' => $originalPath,
                'thumbnail' => $thumbnailPath
            ];
        } catch (\Exception $e) {
            \Log::error("Image upload failed: " . $e->getMessage());
            return null;
        }
    }
}
