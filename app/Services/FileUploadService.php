<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a file to the public/uploads directory with a unique filename.
     *
     * @return string|null The relative path to the uploaded file
     */
    public function upload(UploadedFile $file, string $subfolder = ''): ?string
    {
        // Ensure the uploads directory exists
        $uploadPath = public_path('uploads'.($subfolder ? '/'.$subfolder : ''));
        if (! File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = time().'_'.Str::random(10).'.'.$extension;

        // Full path for storage
        $fullPath = $uploadPath.'/'.$filename;

        // Move the file
        $file->move($uploadPath, $filename);

        // Return relative path
        return 'uploads'.($subfolder ? '/'.$subfolder : '').'/'.$filename;
    }

    /**
     * Delete a file from the public/uploads directory.
     *
     * @param  string  $path  The relative path (e.g., 'uploads/filename.jpg')
     */
    public function delete(string $path): bool
    {
        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
            return File::delete($fullPath);
        }

        return false;
    }

    /**
     * Check if a file exists in the public/uploads directory.
     *
     * @param  string  $path  The relative path
     */
    public function exists(string $path): bool
    {
        return File::exists(public_path($path));
    }
}
