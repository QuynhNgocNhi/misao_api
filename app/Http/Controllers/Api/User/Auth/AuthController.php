<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Traits\HasResponse;

class AuthController extends ApiController
{
    use HasResponse;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Check phone exists
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPhoneExists(Request $request)
    {
        $isExists = User::where('status', 1)->where('phone', $request->phone)->exists();
        return $isExists ? $this->json([], 'Phone is found') : $this->json([], 'Phone is not found', 403);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['phone', 'password']);
        if (!$this->checkAccount(request('phone'))) {
            return $this->json([], 'invalid password or phone number', 403);
        }

        if (!$token = $this->auth()->attempt(['phone' => $request->phone, 'password' => $request->password, 'status' => 1])) {
            throw ValidationException::withMessages([
                'phone' => ['Mật khẩu không đúng!'],
            ]);
        }

        return $this->respondWithToken($token);
    }



    public function resetPassword(Request $request)
    {
        $isExists = UserOtp::where(['phone' => $request->phone, 'otp' => $request->otp, 'status' => 0])->first();
        if ($isExists) {
            UserOtp::where(['phone' => $request->phone, 'otp' => $request->otp])->update(['status' => 1]);
            User::where('phone', $request->phone)->update(['password' => bcrypt($request->password)]);
        }
        return $this->json([]);
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = User::where('id', auth('api')->id())
        ->with('followed')->with('following')
        ->with('product')
        ->with('buyRequest')
        ->first();
        return $this->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->auth()->logout();

        return $this->json([], 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->auth()->refresh());
    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth()->factory()->getTTL() * 600,
            'user_id' => $this->auth()->id()
        ]);
    }

    protected function auth()
    {
        return Auth::guard('api');
    }

    private function checkAccount(string $phone)
    {
        return User::where('phone', $phone)->exists();
    }
}
