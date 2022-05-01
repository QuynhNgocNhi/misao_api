<?php

namespace App\Repositories;

use App\Models\UserFollow;

class UserFollowRepository extends BaseRepository
{
    function modelName(): string
    {
        return UserFollow::class;
    }
}
