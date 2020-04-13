<?php

namespace Tenant\Services;

use TrivYeah\Support\Fluent;

class FileService
{
    public function createFileFromBase64(string $base64, $mime)
    {
        if (strpos($base64, ",")) $base64 = explode(",", $base64)[1];

        $decodedFile = base64_decode($base64);
        $file = uniqid("file_") . "." . $mime;
        $filePath = storage_path($file);

        file_put_contents($filePath, $decodedFile);

        return $filePath;
    }

    public function unlinkFile($filePath)
    {
        if (file_exists($filePath)) unlink($filePath);
    }
}