<?php

namespace App\Services\Api;

use App\Repositories\UserMediaRepository;
use App\Services\FileService;

class UserMediaService
{
    public function __construct(
        private UserMediaRepository $userMediaRepository,
        private FileService $fileService
    ) {
    }

    public function upload($userID, $files)
    {
        $medias = [];
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $file) {
            $saved = $this->fileService->uploadFile($file, '/uploads/medias');
            // $medias[] = $this->store($userID, $saved['path']);
        }
        return $saved;
    }

    private function store($userID, string $path)
    {
        return $this->userMediaRepository->create([
            'url'               => $path,
            'user_id' => $userID
        ]);
    }
}
