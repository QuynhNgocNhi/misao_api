<?php

namespace App\Repositories;

use App\Models\ProductFavorite;

class ProductFavoriteRepository extends BaseRepository
{
    function modelName(): string
    {
        return ProductFavorite::class;
    }
}
