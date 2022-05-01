<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends ApiController {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        $crendentials = $this->credentials($request);
        $crendentials['token'] = $token;
        $user = $this->validateReset($crendentials);

        return view('pages.auth.password.reset')->with(
            ['token' => $token, 'email' => $request->email, 'isTokenExpired' => !$user instanceof CanResetPasswordContract]
        );
    }

    protected function validateReset($credentials)
    {
        if (is_null($user = $this->broker()->getUser($credentials))) {
            return Password::INVALID_USER;
        }

        if (!$this->broker()->tokenExists($user, $credentials['token'])) {
            return Password::INVALID_TOKEN;
        }

        return $user;
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return $this->json(['message' => trans($response)], trans($response));
        }

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }
}
