<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Вспомогательный класс для процессов обработки файлов
 */
readonly class FileHelper
{
    /**
     * Генерирует и возвращает уникальное имя файла
     *
     * @param UploadedFile $file
     * @return string
     */
    public static function generateUniqueFileName(UploadedFile $file): string
    {
        return Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
    }
}
