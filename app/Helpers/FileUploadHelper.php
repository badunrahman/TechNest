<?php

namespace App\Helpers;

use App\Helpers\Core\Result;
use App\Helpers\Core\ResultDataException;
use App\Helpers\Core\ResultErrorException;
use Psr\Http\Message\UploadedFileInterface;



class FileUploadHelper
{
    /**
     * Upload a file with validation and return a Result.
     *
     * @param UploadedFileInterface $uploadedFile The uploaded file from the request
     * @param array $config Configuration options:
     *   - 'directory' (string): Upload directory path (required)
     *   - 'allowedTypes' (array): Array of allowed media types (required)
     *   - 'maxSize' (int): Maximum file size in bytes (required)
     *   - 'filenamePrefix' (string): Prefix for generated filenames (default: 'upload_')
     * @return Result Success with filename, or failure with error message
     */
    public static function upload(UploadedFileInterface $uploadedFile, array $config): Result
    {
        // You'll implement the method body in the following steps

        $directory = $config['directory'] ?? null;
        $allowedTypes = $config['allowedTypes'] ?? [];
        $maxSize = $config['maxSize'] ?? 0;
        $filenamePrefix = $config['filenamePrefix'] ?? 'upload_';

        if (!$directory) {
            return Result::failure('Upload directory not specified in configuration');
        };

        if (empty($allowedTypes)) {
            return Result::failure('Allowed file type not specified in configuration');
        }

        if ($maxSize <= 0) {
            return Result::failure('Maximum file size not specified in configuration');
        }


        // valadating the uploaded file

        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return Result::failure('Error uploading file');
        }

        $fileSize = $uploadedFile->getSize();
        if ($fileSize > $maxSize) {
            $maxSizeInMb = round($maxSize / (124 * 1024), 1);
            return Result::failure("File too large (max {$maxSizeInMb} MB)");
        }

        $mediaType = $uploadedFile->getClientMediaType();
        if (!in_array($mediaType, $allowedTypes, true)) {
            return Result::failure('Invalid file type. Only ' . implode(',', $allowedTypes) . 'allowed');
        }


        // generating a safe filename for the file uploads
        $clientFileName = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $extension = $clientFileName;
        if (!empty($extension)) {
            $fileName = uniqid($filenamePrefix) . '.' . $extension;
        }

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
                return Result::failure('Failed to create upload directory');
            }
        }

        $destination = $directory . DIRECTORY_SEPARATOR . $fileName;

        try {
            $uploadedFile->moveTo($destination);
        } catch (\Throwable $e) {
            return Result::failure('Failed to save uploaded file:' . $e->getMessage());
        }

        return Result::success('File uploaded successfully', ['filename' => $fileName]);
    }
}
