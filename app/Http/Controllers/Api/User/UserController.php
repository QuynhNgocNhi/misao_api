<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Services\Api\UserFollowService;
use App\Services\Api\UserService;

class UserController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private UserFollowService $userFollowService,
        private UserService $userService
    ) {
    }


    public function follow(int $userFollowedId)
    {
        $params = [
            'followed_id'  => $userFollowedId,
            'following_id' => auth('api')->id(),
        ];
        $result = $this->userFollowService->store($params);
        return $this->json([], $result ? 'success' : 'error', $result ? 200 : 400);
    }
    public function profile(int $userId)
    {
        $result = User::with('followed')
            ->with('following')
            ->with('product')
            ->with('buyRequest')->find($userId);
        return $this->json($result);
    }
}
