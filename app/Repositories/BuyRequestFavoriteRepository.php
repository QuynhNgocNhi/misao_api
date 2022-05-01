<?php

namespace App\Repositories;

use App\Models\BuyRequestFavorite;

class BuyRequestFavoriteRepository extends BaseRepository
{
    function modelName(): string
    {
        return BuyRequestFavorite::class;
    }
}
