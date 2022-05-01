<?php

namespace App\Services\Api;

use App\Repositories\BuyRequestMediaRepository;
use App\Services\FileService;

class BuyRequestMediaService
{
    public function __construct(
        private BuyRequestMediaRepository $productMediaRepository,
        private FileService $fileService
    ) {
    }

    public function upload($productID, $files)
    {
        $medias = [];
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $file) {
            $saved = $this->fileService->uploadFile($file, '/uploads/medias');
            $medias[] = $this->store($productID, $saved['path']);
        }
        return $medias;
    }

    private function store($productID, string $path)
    {
        return $this->productMediaRepository->create([
            'url'               => $path,
            'buy_request_id' => $productID
        ]);
    }
}
