<?php

namespace App\Services\Api;

use App\Models\User;
use App\Repositories\SearchHistoryRepository;
use Illuminate\Support\Arr;

class SearchHistoryService
{
    public function __construct(
        private SearchHistoryRepository $searchHistoryRepository)
    {
    }

    public function getList(array $params)
    {
        $params = [
            'where_equals' => [
                'user_id' => Arr::get($params, 'user_id')
            ],
            'sort'         => Arr::get($params, 'sort', 'updated_at:desc'),
        ];
        return $this->searchHistoryRepository->paginate($params);
    }

    public function delete($id)
    {
        $searchHistory = $this->searchHistoryRepository->show($id, auth()->id());
        if (!$searchHistory) return false;
        $searchHistory->delete();
        return true;
    }

    public function store(array $queries, User $user)
    {
        $queries = array_filter($queries, function ($value) {
            return !is_null($value);
        });
        unset($queries['page'], $queries['limit']);
        ksort($queries);
        if (empty($queries)) {
            return;
        }

        $md5           = md5(json_encode($queries));
        $userId        = $user['id'];
        $params        = [
            'where_equals' => [
                'user_id' => $userId,
                'md5'     => $md5
            ]
        ];
        $searchHistory = $this->searchHistoryRepository->filter($params)->exists();
        if ($searchHistory) {
            return;
        }
        $params = [
            'user_id' => $userId,
            'query'   => $queries,
            'md5'     => $md5
        ];
        $this->searchHistoryRepository->create($params);
    }
}
