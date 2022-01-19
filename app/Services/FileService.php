<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;

class FileService
{
    /**
     * @param UploadedFile $file
     * @return string
     * @throws Exception
     */
    public static function handle(UploadedFile $file): string
    {
        if ($path = $file->store('attachments')) {
            return $path;
        }

        throw new Exception('Cant upload file');
    }
}
