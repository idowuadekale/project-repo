<?php

namespace App\Services;

use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class CloudinaryService
{
    protected UploadApi $upload;
    protected AdminApi $admin;

    public function __construct()
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => ['secure' => true],
        ]);

        $this->upload = new UploadApi();
        $this->admin = new AdminApi();
    }

    /**
     * Upload a PDF to Cloudinary.
     * Returns ['url' => ..., 'public_id' => ...].
     */
    public function uploadPdf(string $filePath, string $publicId): array
    {
        $result = $this->upload->upload($filePath, [
            'resource_type' => 'raw',           // PDFs are raw files
            'folder' => 'lasu-repo/projects',
            'public_id' => $publicId,
            'overwrite' => true,
            'use_filename' => false,
            // Compress: reduce file size while preserving quality
            'transformation' => [],             // PDFs don't transform like images
            'format' => 'pdf',
            'flags' => 'attachment',   // Force download on access
        ]);

        return [
            'url' => $result['secure_url'],
            'public_id' => $result['public_id'],
        ];
    }

    /**
     * Upload a profile photo — auto-crop face, compress.
     */
    public function uploadAvatar(string $filePath, int $userId): array
    {
        $result = $this->upload->upload($filePath, [
            'resource_type' => 'image',
            'folder' => 'lasu-repo/avatars',
            'public_id' => 'user_'.$userId,
            'overwrite' => true,
            'transformation' => [
                ['width' => 300, 'height' => 300,
                    'crop' => 'fill', 'gravity' => 'face'],
                ['quality' => 'auto:good', 'fetch_format' => 'auto'],
            ],
        ]);

        return [
            'url' => $result['secure_url'],
            'public_id' => $result['public_id'],
        ];
    }

    /**
     * Delete a file from Cloudinary by public_id.
     */
    public function delete(string $publicId, string $resourceType = 'raw'): void
    {
        try {
            $this->upload->destroy($publicId, [
                'resource_type' => $resourceType,
            ]);
        } catch (\Throwable $e) {
            // Log but don't crash — deletion failure is non-critical
            \Log::warning("Cloudinary delete failed for {$publicId}: ".$e->getMessage());
        }
    }

    /**
     * Extract public_id from a Cloudinary URL.
     * e.g. https://res.cloudinary.com/name/raw/upload/v123/lasu-repo/projects/proj_1.pdf
     * returns: lasu-repo/projects/proj_1.
     */
    public function extractPublicId(string $url, bool $withExtension = false): string
    {
        // Remove query string
        $url = strtok($url, '?');

        // Everything after /upload/vXXXX/ or /upload/
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+)$/', $url, $matches)) {
            $path = $matches[1];

            return $withExtension ? $path : preg_replace('/\.[^.]+$/', '', $path);
        }

        return '';
    }
}
