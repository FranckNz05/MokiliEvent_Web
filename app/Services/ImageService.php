<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageService
{
    // Dimensions for profile photos
    const PROFILE_WIDTH = 300;
    const PROFILE_HEIGHT = 300;

    // Dimensions for event images
    const EVENT_WIDTH = 800;
    const EVENT_HEIGHT = 600;

    /**
     * Handle profile photo upload and processing
     */
    public function handleProfilePhoto(UploadedFile $file): string
    {
        // Create storage directory if it doesn't exist
        $path = 'public/profile-photos';
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        // Generate unique filename
        $fileName = uniqid('profile_') . '.' . $file->getClientOriginalExtension();
        $fullPath = $path . '/' . $fileName;

        // Create and process image
        $image = Image::make($file)
            ->fit(self::PROFILE_WIDTH, self::PROFILE_HEIGHT, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        // Save processed image
        Storage::put($fullPath, (string) $image->encode());

        // Return the public URL
        return Storage::url($fullPath);
    }

    /**
     * Handle event image upload and processing
     */
    public function handleEventImage(UploadedFile $file): string
    {
        // Create storage directory if it doesn't exist
        $path = 'public/event-images';
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        // Generate unique filename
        $fileName = uniqid('event_') . '.' . $file->getClientOriginalExtension();
        $fullPath = $path . '/' . $fileName;

        // Create and process image
        $image = Image::make($file)
            ->fit(self::EVENT_WIDTH, self::EVENT_HEIGHT, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        // Save processed image
        Storage::put($fullPath, (string) $image->encode());

        // Return the public URL
        return Storage::url($fullPath);
    }
}
