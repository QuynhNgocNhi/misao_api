<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository {
    function modelName(): string
    {
        return User::class;
    }
}
