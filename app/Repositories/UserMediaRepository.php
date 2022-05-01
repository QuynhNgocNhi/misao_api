<?php

namespace App\Repositories;

use App\Models\UserMedia;

class UserMediaRepository extends BaseRepository
{
    function modelName(): string
    {
        return UserMedia::class;
    }

    public function updateUserToMedia(array $mediaActive, int $userId)
    {
        foreach ($mediaActive as $media) {
            $this->getModel()->where('id', $media['id'])->update([
                'user_id'         => $userId,
            ]);
        }
        return true;
    }
}
