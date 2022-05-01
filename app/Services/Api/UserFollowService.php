<?php

namespace App\Services\Api;

use App\Repositories\UserFollowRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class UserFollowService
{
    public function __construct(private UserFollowRepository $userFollowRepository)
    {
    }

    public function getList(array $params)
    {
    }

    public function find(array $params)
    {
        $whereEquals = [
            'product_id'  => Arr::get($params, 'product_id'),
            'user_id' => Arr::get($params, 'user_id'),
        ];
        $params       = [
            'where_equals' => $whereEquals
        ];
        return $this->userFollowRepository->filter($params)->withTrashed()->first();
    }

    public function store(array $params)
    {
        $followedId     = Arr::get($params, 'followed_id');
        $userId    = Arr::get($params, 'following_id');
        $keyCache  = 'follow' . $followedId . $userId;
        if (Cache::has($keyCache)) {
            return 'Vui lòng không gửi yêu cầu liên tục';
        }
        Cache::put($keyCache, 'clicked', 2);
        $input = [
            'followed_id'  => $followedId,
            'following_id' => $userId,
        ];
        $userFollow       = $this->find($input);
        if ($userFollow) {
            if (is_null($userFollow->deleted_at)) {
                return $this->delete($userFollow->id) ? 'Đã hủy theo dõi.' : false;
            } else {
                return $userFollow->restore() ? 'Đã theo dõi.' : false;
            }
        }
        return $this->userFollowRepository->create($input) ? 'Đã theo dõi.' : false;
    }

    public function delete(int $id)
    {
        return $this->userFollowRepository->delete($id);
    }
}
