<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class NotificationRepository extends BaseRepository {
    function modelName(): string
    {
        return Notification::class;
    }

    public function filter(array $params): Builder
    {
        $userId = Arr::get($params, 'user_id');
        if ($userId) {
            unset($params['user_id'], $params['sort']);
        }

        $query = parent::filter($params);

        return $query
            ->when($userId, function ($query) use ($userId) {
                $query->leftJoin('user_notification AS un', function ($join) use($userId){
                    $join->on('un.notification_id', '=', 'notifications.id');
                    $join->where('un.user_id', $userId);
                    $join->whereNull('un.deleted_at');
                });
                $query->select(['notifications.*', DB::raw('IF(SUM(un.id), 0, 1) AS is_new')]);
                $query->where(function ($q) use ($userId) {
                    $q->Where('notifications.user_id', $userId)->orWhereNull('notifications.user_id');
                });
                $query->orderBy('notifications.created_at', 'desc');
                $query->groupBy('notifications.id');
            });
    }
}
