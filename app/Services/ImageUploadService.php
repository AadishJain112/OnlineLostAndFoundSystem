<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /** @param array<int, UploadedFile> $files */
    public function storeMany(Model $model, array $files, string $folder): void
    {
        foreach ($files as $index => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $file->store($folder.'/'.date('Y/m'), 'public');

            $model->images()->create([
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'sort_order' => $index,
            ]);
        }
    }

    public function deleteAll(Model $model): void
    {
        foreach ($model->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }

    public static function verificationCode(): string
    {
        return Str::upper(Str::random(12));
    }
}
