<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Services\Api\UserService;
use App\Traits\HasResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends \App\Http\Controllers\Auth\RegisterController
{

    use HasResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private UserService $userService)
    {
        request()->headers->set('Accept', 'application/json');
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
    public function prepareRegister(Request $request)
    {
        $data = [
            'otp' => $this->userService->sendOTPRegister($request->phone)
        ];
        return $this->json($data);
    }

    public function prepareForgetPassword(Request $request)
    {
        $data = [
            'otp' => $this->userService->sendOTPPassword($request->phone)
        ];
        return $this->json($data);
    }



    public function sendOTP(Request $request)
    {
        return $this->userService->sendOTPRegister($request->phone);
    }

    protected function registered(Request $request, $user)
    {
        return $this->json([], 'success');
    }
}
