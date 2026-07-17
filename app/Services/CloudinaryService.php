<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    protected Cloudinary $sdk;

    public function __construct()
    {
        $this->sdk = new Cloudinary(env('CLOUDINARY_URL'));
    }

    public function uploadPdf(string $filePath, string $publicId): array
    {
        $result = $this->sdk->uploadApi()->upload($filePath, [
            'resource_type' => 'raw',
            'folder' => 'lasu-repo/projects',
            'public_id' => $publicId,
            'overwrite' => true,
        ]);

        return [
            'url' => $result['secure_url'],
            'public_id' => $result['public_id'],
        ];
    }

    public function uploadAvatar(string $filePath, int $userId): array
    {
        $result = $this->sdk->uploadApi()->upload($filePath, [
            'resource_type' => 'image',
            'folder' => 'lasu-repo/avatars',
            'public_id' => 'user_'.$userId,
            'overwrite' => true,
            'transformation' => [
                ['width' => 300, 'height' => 300, 'crop' => 'fill', 'gravity' => 'face'],
                ['quality' => 'auto:good', 'fetch_format' => 'auto'],
            ],
        ]);

        return [
            'url' => $result['secure_url'],
            'public_id' => $result['public_id'],
        ];
    }

    public function delete(string $publicId, string $resourceType = 'raw'): void
    {
        try {
            $this->sdk->uploadApi()->destroy($publicId, [
                'resource_type' => $resourceType,
            ]);
        } catch (\Throwable $e) {
            Log::warning("Cloudinary delete failed [{$publicId}]: ".$e->getMessage());
        }
    }
}
