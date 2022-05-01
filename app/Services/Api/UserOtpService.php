<?php

namespace App\Services\Api;

use App\Models\UserOtp;
use App\Repositories\UserOtpRepository;

class UserOtpService
{
    public function __construct(
        private UserOtpRepository $userOtpRepository,
    ) {
    }

    public function isValidOtp($phone, $otp)
    {
        $result = UserOtp::where(['phone' => $phone, 'otp' => $otp])->first();
        return $result;
    }

    public function store($otp,  $phone)
    {
        return $this->userOtpRepository->create([
            'otp'               => $otp,
            'phone' => $phone,
        ]);
    }

    public function updateStatus($otp,  $phone)
    {
        $result = UserOtp::where(['phone' => $phone, 'otp' => $otp])->first();
        $param = [
            'status' => 1
        ];
        return $this->userOtpRepository->update($result->id, $param);
    }
}
