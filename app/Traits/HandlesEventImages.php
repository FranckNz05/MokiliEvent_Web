<?php

namespace App\Traits;

use App\Services\ImageService;
use Illuminate\Http\UploadedFile;

trait HandlesEventImages
{
    /**
     * Traite l'image de l'événement
     */
    protected function handleEventImage(UploadedFile $file): string
    {
        return app(ImageService::class)->handleEventImage($file);
    }

    /**
     * Supprime l'image de l'événement
     */
    protected function deleteEventImage(?string $imagePath): void
    {
        if ($imagePath && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
            Storage::delete($imagePath);
        }
    }
}
