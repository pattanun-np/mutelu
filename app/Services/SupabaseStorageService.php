<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseStorageService
{
    protected $supabaseUrl;
    protected $supabaseKey;
    protected $bucketName;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL');
        $this->supabaseKey = env('SUPABASE_KEY');
        $this->bucketName = env('SUPABASE_BUCKET', 'sacredplaces');
    }

    /**
     * Upload a file to Supabase Storage
     *
     * @param UploadedFile $file
     * @param string|null $path
     * @return string|null The public URL of the uploaded file
     */
    public function upload(UploadedFile $file, ?string $path = null): ?string
    {
        // Generate a unique filename
        $filename = $path ? $path . '/' . Str::uuid() . '.' . $file->getClientOriginalExtension()
            : Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Get file contents
        $contents = file_get_contents($file->getRealPath());

        // Upload to Supabase
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => $file->getMimeType(),
        ])->put(
            "{$this->supabaseUrl}/storage/v1/object/{$this->bucketName}/{$filename}",
            $contents
        );

        if ($response->successful()) {
            // Return the public URL
            return "{$this->supabaseUrl}/storage/v1/object/public/{$this->bucketName}/{$filename}";
        }

        return null;
    }

    /**
     * Delete a file from Supabase Storage
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        // Extract the filename from the full URL if needed
        if (Str::startsWith($path, $this->supabaseUrl)) {
            $path = Str::after($path, "/storage/v1/object/public/{$this->bucketName}/");
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete(
            "{$this->supabaseUrl}/storage/v1/object/{$this->bucketName}/{$path}"
        );

        return $response->successful();
    }
}
