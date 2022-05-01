<?php

namespace App\Repositories;

use App\Models\BuyRequestMedia;

class BuyRequestMediaRepository extends BaseRepository
{
    function modelName(): string
    {
        return BuyRequestMedia::class;
    }

    public function updateProductToMedia(array $mediaActive, int $productId)
    {
        foreach ($mediaActive as $media) {
            $this->getModel()->where('id', $media['id'])->update([
                'buy_request_id'         => $productId,
            ]);
        }
        return true;
    }
}
