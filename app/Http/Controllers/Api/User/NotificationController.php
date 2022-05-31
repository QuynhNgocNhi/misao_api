<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Services\Api\NotificationService;
use App\Services\Api\UserNotificationService;

class NotificationController extends ApiController
{
    public function __construct(
        private NotificationService $notificationService,
        private UserNotificationService $userNotificationService
    ) {
    }

    public function index()
    {
        $params = [
            'status' => 1,
            'user_id' => auth('api')->id(),
        ];

        $data = $this->notificationService->get($params);

        return $this->json($data);
    }

    public function show($id)
    {
        $userId = auth('api')->id();
        $notification = $this->notificationService->show($id, $userId);
        if (!$notification || ($notification->user_id && $notification->user_id != $userId) || $notification->status != ACTIVE) {
            abort(404);
        }

        // update read at
        $this->userNotificationService->store(['notification_id' => $notification->id, 'user_id' => $userId]);

        return $this->json($notification);
    }
}
