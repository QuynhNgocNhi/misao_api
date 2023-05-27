<?php

namespace App\Services\Api;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Http;

class UserService
{
    private const OTP_URL = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_post_json/";

    public function __construct(private UserRepository $userRepository, private UserOtpService $userOtpService)
    {
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function show($id = null)
    {
        $id = empty($id) ? auth()->id() : $id;
        return $this->userRepository->find($id);
    }

    public function sendOTPRegister(string $phone)
    {
        $otp = $this->generateNumericOTP(6);
        $response = Http::withHeaders([
            "content-type" => "application/json"
        ])->post(self::OTP_URL, $this->prepareParamsRegister($phone, (string) $otp));
        $result = json_decode($response->body(), true);
        if ($result['CodeResult'] === '100') {
            $this->userOtpService->store($otp, $phone);
        }
        return $result['CodeResult'] === '100' ? $otp : null;
    }
    function prepareParamsRegister($phone, string $otp)
    {
        return [
            "ApiKey" => "172B7865F1CF01A53B2442C2BA4A9C",
            "Content" => 'IQOSVIETNAM: ' . (string) $otp . ' la Ma OTP de dang ky tai khoan cua quy khach. Ma co hieu luc trong 5 phut iqosvietnam.com.vn',
            "Phone" => $phone,
            "SecretKey" => "E1A059FFC584F72ED76BBCB5F444F6",
            "SmsType" => "2",
            "Brandname" => "IQOSVIETNAM",
            "Sandbox" => "0"
        ];
    }

    public function sendOTPPassword(string $phone)
    {
        $otp = $this->generateNumericOTP(6);
        $response = Http::withHeaders([
            "content-type" => "application/json"
        ])->post(self::OTP_URL, $this->prepareParamsPassword($phone, $otp));
        $result = json_decode($response->body(), true);
        if ($result['CodeResult'] === '100') {
            $this->userOtpService->store($otp, $phone);
        }
        return $result['CodeResult'] === '100' ? $otp : null;
    }
    function prepareParamsPassword($phone, int $otp)
    {
        return [
            "ApiKey" => "172B7865F1CF01A53B2442C2BA4A9C",
            "Content" => 'IQOSVIETNAM: ' . (string) $otp . ' la Ma OTP de dang ky tai khoan cua quy khach. Ma co hieu luc trong 5 phut iqosvietnam.com.vn',
            "Phone" => $phone,
            "SecretKey" => "E1A059FFC584F72ED76BBCB5F444F6",
            "SmsType" => "2",
            "Brandname" => "IQOSVIETNAM",
            "Sandbox" => "0"
        ];
    }

    function generateNumericOTP($n)
    {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }

    public function updatePassword($params)
    {
        $account           = $this->userRepository->find(auth()->id());
        $account->password = bcrypt($params['password']);
        return $account->save();
    }

    public function update($id, array $params)
    {
        return $this->userRepository->update($id, $params);
    }
}
