<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Services\Api\UserFollowService;

class UserController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private UserFollowService $userFollowService,
    ) {
    }


    public function follow($userFollowedId)
    {
        $params = [
            'followed_id'  => $userFollowedId,
            'following_id' => auth('api')->id(),
        ];
        $result = $this->userFollowService->store($params);
        return $this->json([], $result ? 'success' : 'error', $result ? 200 : 400);
    }
}
