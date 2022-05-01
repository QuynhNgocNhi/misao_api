<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Services\Api\UserMediaService;
use App\Services\Api\UserService;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class AccountController extends ApiController
{
    use HasResponse;

    public function __construct(private UserService $userService, private UserMediaService $userMediaService)
    {
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $result  = $this->userService->updatePassword($request->validated());
        return $result ? $this->responseSuccess() : $this->responseError();
    }

    public function upload($userID, $files)
    {
        $medias = $this->userMediaService->upload($userID, $files);
        return $medias;
    }

    public function updateUserProfile(Request $request)
    {

        if ($request->file('files')) {
            $files = $request->file('files');
            $medias = $this->upload(auth('api')->id(), $files);
        }
        $paramsUpdate = $request->all();
        $paramsUpdate['profile_image'] = $medias['path'];
        $result = $this->userService->update(auth('api')->id(), $paramsUpdate);
        return $this->json(
            $result ?: [],
            $result ? 'success' : 'error',
            $result ? 200 : 400
        );
    }
}
