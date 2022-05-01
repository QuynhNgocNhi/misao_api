<?php

namespace App\Repositories;

use App\Models\UserOtp;

class UserOtpRepository extends BaseRepository
{
    function modelName(): string
    {
        return UserOtp::class;
    }

}
