<?php

namespace App\Repositories;

use App\Models\ProductMedia;

class ProductMediaRepository extends BaseRepository
{
    function modelName(): string
    {
        return ProductMedia::class;
    }

    public function updateProductToMedia(array $mediaActive, int $productId)
    {
        foreach ($mediaActive as $media) {
            $this->getModel()->where('id', $media['id'])->update([
                'product_id'         => $productId,
            ]);
        }
        return true;
    }
}
