<?php

namespace App\Services\Api;

use App\Repositories\UserNotificationRepository;
use Illuminate\Support\Arr;

class UserNotificationService {
    public function __construct(private UserNotificationRepository $userNotificationRepository)
    {
    }

    public function getList(array $params)
    {

    }

    public function find(array $params)
    {
        $whereEquals = [
            'notification_id' => Arr::get($params, 'notification_id'),
            'user_id' => Arr::get($params, 'user_id'),
        ];
        $params = [
            'where_equals' => $whereEquals
        ];
        return $this->userNotificationRepository->filter($params)->first();
    }

    public function store(array $params)
    {
        $input = [
            'notification_id' => Arr::get($params, 'notification_id'),
            'user_id' => Arr::get($params, 'user_id'),
        ];

        $userNotification = $this->find($input);
        if ($userNotification) {
            return $userNotification;
        }

        return $this->userNotificationRepository->create($input);
    }

    public function delete(int $id)
    {
        return $this->userNotificationRepository->forceDelete($id);
    }
}
