<?php

namespace App\Repositories;

use App\Models\SearchHistory;
use App\Models\User;

class SearchHistoryRepository extends BaseRepository {

    function modelName(): string
    {
        return SearchHistory::class;
    }

    public function show(int $id, int $userId = null)
    {
        return $this->getModel()->where('id', $id)
                    ->when($userId, function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })->first();
    }

    public function saveQueryString(array $queries, User $user)
    {
        if (empty($queries)) {
            return;
        }
        $queries = array_filter($queries, function ($value) {
            return !is_null($value);
        });
        $queries = ksort($queries);

        $md5 = md5(json_encode($queries));
        $userId = $user['id'];
        $params = [
            'where_equals' => [
                'user_id' => $userId,
                'md5' => $md5
            ]
        ];

        $searchHistory = $this->filter($params)->exists();
        if ($searchHistory) {
            return;
        }

        $params = [
            'user_id' => $userId,
            'query' => $queries,
            'md5' => $md5
        ];
        $this->create($params);
    }
}
