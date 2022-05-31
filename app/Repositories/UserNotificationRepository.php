<?php

namespace App\Repositories;

use App\Models\UserNotification;

class UserNotificationRepository extends BaseRepository {
    function modelName(): string
    {
        return UserNotification::class;
    }
}
