<?php

declare(strict_types=1);

namespace App\Helpers;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class MediaLibraryPathGenerator implements PathGenerator
{
    /**
     * @param Media $media
     * @return string
     */
    public function getPath(Media $media): string
    {
        $modelName = Str::snake(Str::pluralStudly(class_basename($media->model)));

        return sprintf(
            '%s/%s/',
            $modelName,
            $media->model->uuid
        );
    }

    /**
     * @param Media $media
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return rtrim($this->getPath($media)) . '/conversions';
    }

    /**
     * @param Media $media
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return rtrim($this->getPath($media)) . '/responsive-images';
    }
}
