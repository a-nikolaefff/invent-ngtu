<?php

namespace Database\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\HasMedia;

/**
 * Class FileLoader
 *
 * Represents a utility class for loading files into a media collection of a model.
 */
class FileLoader
{
    public static function load(HasMedia $model, string $folderPath, string $collectionName): void
    {
        $exampleFilesPath = storage_path($folderPath);
        $copiedFilesPath = storage_path('app/temp');

        // Create the 'copied_examples' directory if it doesn't exist
        if (! File::exists($copiedFilesPath)) {
            File::makeDirectory($copiedFilesPath);
        }

        // Get all files from the examples directory
        $exampleFiles = File::allFiles($exampleFilesPath);

        // Add each file to the media collection for the model
        foreach ($exampleFiles as $file) {
            // Copy the file to the 'copied_examples' directory
            $copiedFilePath = $copiedFilesPath.'/'.$file->getFilename();
            File::copy($file->getRealPath(), $copiedFilePath);

            // Get random user
            $user = User::all()->random();

            // Add the copied file to the media collection for the model
            $model->addMedia($copiedFilePath)
                ->withCustomProperties([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'datetime' => Carbon::now()->format('d.m.Y H:i:s'),
                ])
                ->toMediaCollection($collectionName);
        }
    }
}
