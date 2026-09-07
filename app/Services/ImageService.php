<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    protected $sizes = [
        'small' => [100, 100],
        'medium' => [300, 300],
        'large' => [800, 800],
        'original' => [null, null],
    ];

    public function getImage(string $image, string $size = 'original')
    {
        if (! array_key_exists($size, $this->sizes)) {
            return null;
        }

        if (empty($image)) {
            return null;
        }

        if (str($image)->startsWith(['http', 'https'])) {
            return $image;
        }

        if (! Storage::disk('local')->exists($image)) {
            return null;
        }

        $cachePath = "cache/{$size}/{$image}";
        if (Storage::disk('public')->exists($cachePath) &&
            Storage::disk('public')->lastModified($cachePath) > Storage::disk('local')->lastModified($image)) {
            return Storage::disk('public')->url($cachePath);
        }

        File::exists(dirname(Storage::disk('public')->path($cachePath))) ||
            File::makeDirectory(dirname(Storage::disk('public')->path($cachePath)), 0755, true);

        $image = Image::decodePath(Storage::disk('local')->path($image));

        [$width, $height] = match ($size) {
            'original' => [$image->width(), $image->height()],
            default => $this->sizes[$size],
        };
        $image->scale($width, $height);
        $image->resizeCanvas($width, $height);
        $image->save(Storage::disk('public')->path($cachePath));

        unset($image);

        return Storage::disk('public')->url($cachePath);
    }
}
