<?php

namespace Modules\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Alignment;
use Intervention\Image\Laravel\Facades\Image;

trait HasImage
{
    protected $sizes = [
        'small' => [150, 150],
        'medium' => [300, 300],
        'large' => [800, 800],
        'original' => [0, 0],
    ];

    public static function bootHasImage()
    {
        static::deleting(function (Model $model) {
            $model->deleteImage();
        });
        static::created(function (Model $model) {
            if ($model->isDirty($model->imageSource())) {
                $model->storeImage();
            }

        });
        static::updated(function (Model $model) {
            if ($model->wasChanged($model->imageSource())) {
                if ($model->getOriginal($model->imageSource())) {
                    $model->deleteImage();
                }
            }
            if ($model->isDirty($model->imageSource()) && filled($model->getOriginal($model->imageSource()))) {
                $model->storeImage();
            }
        });
    }

    private function storeImage()
    {
        if (Storage::disk('local')->exists($this->{$this->imageSource()})) {
            try {
                $image = Image::decodePath(Storage::disk('local')->path($this->{$this->imageSource()}));
            } catch (\Exception $e) {
                return;
            }
            $background = $image->colorAt(0, 0);
            [$width, $height] = $this->imageSize();
            if ($image->width() > $image->height()) {
                $image->scaleDown(width: $width);
            } else {
                $image->scaleDown(height: $height);
            }
            $image->crop($width, $height, background: $background, alignment: Alignment::CENTER);
            $image->save();
        }
    }

    public function getImage($size = 'original')
    {
        if (! array_key_exists($size, $this->sizes)) {
            return null;
        }

        $originalPath = $this->{$this->imageSource()};

        if (empty($this->{$this->imageSource()})) {
            return null;
        }

        if (str($originalPath)->startsWith(['http', 'https'])) {
            return $this->{$this->imageSource()};
        }

        if (! Storage::disk('local')->exists($originalPath)) {
            return null;
        }

        $cachePath = "cache/{$size}/{$this->{$this->imageSource()}}";

        if (Storage::disk('public')->exists($cachePath) &&
        Storage::disk('public')->lastModified($cachePath) > Storage::disk('local')->lastModified($originalPath)
        ) {
            return Storage::disk('public')->url($cachePath);
        }

        File::exists(dirname(Storage::disk('public')->path($cachePath)))
        or File::makeDirectory(dirname(Storage::disk('public')->path($cachePath)), 0755, true);

        try {
            $image = Image::decodePath(Storage::disk('local')->path($originalPath));
        } catch (\Exception $e) {
            return null;
        }

        // dd($originalPath, $cachePath);
        [$width, $height] = match ($size) {
            'original' => [$image->width(), $image->height()],
            default => $this->sizes[$size],
        };

        $image->scale($width, $height);
        $image->resizeCanvas($width, $height);
        $image->save(Storage::disk('public')->path($cachePath));

        return Storage::disk('public')->url($cachePath);

    }

    protected function deleteImage()
    {
        foreach ($this->sizes as $size => $dimensions) {
            $cachePath = "cache/{$size}/{$this->getOriginal($this->imageSource())}";
            Storage::disk('public')->delete($cachePath);
        }
        if ($this->getOriginal($this->imageSource())) {
            Storage::disk('local')->delete($this->getOriginal($this->imageSource()));
        }
    }

    public function imageSource()
    {
        return 'image';
    }

    public function imageSize()
    {
        return [800, 800];
    }
}
