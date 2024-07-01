<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Filters\FilterInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait StoreMedia
{
    public function storeMedia(
        array|UploadedFile|null $files,
        string $mediaCollection
    ) {
        foreach ($files as $file) {
            $this->addMedia($file)
                ->withCustomProperties([
                    'user_id' => Auth::user()->id,
                    'user_name' => Auth::user()->name,
                    'datetime' => Carbon::now()->format('d.m.Y H:i:s')
                ])
                ->toMediaCollection($mediaCollection);
        }
    }
}
