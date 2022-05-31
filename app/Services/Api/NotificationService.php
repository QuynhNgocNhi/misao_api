<?php

namespace App\Services\Api;

use App\Repositories\NotificationRepository;
use Illuminate\Support\Arr;

class NotificationService
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function get(array $params = [], $limit = PER_PAGE)
    {
        $userId = Arr::get($params, 'user_id');
        $whereEquals = [
            'status' => Arr::get($params, 'status'),
        ];

        $whereLikes = [];

        $sorts = [];

        $relates = [];
        if ($userId) {
            $relates['user_notification'] = function ($query) use ($userId) {
                $query->where('user_id', $userId);
            };
        }

        $params = [
            'where_equals' => $whereEquals,
            'where_likes' => $whereLikes,
            'sort' => Arr::get($params, 'sort', 'updated_at:desc'),
            'sorts' => $sorts,
            'relates' => $relates,
            'user_id' => $userId
        ];

        return $limit > 0 ? $this->notificationRepository->paginate($params, $limit) : $this->notificationRepository->get($params);
    }

    public function show($id, $userId = null)
    {
        $notification = $this->notificationRepository->find($id);
        if (!$notification) {
            return null;
        }
        if ($userId) {
            $notification->load(['user_notification' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }]);
            $notification->is_new = $notification->user_notification->isEmpty() ? 1 : 0;
        } else {
            $notification->is_new = 0;
        }

        return $notification;
    }

    public function create($params)
    {
        return $this->notificationRepository->create($params);
    }
}
