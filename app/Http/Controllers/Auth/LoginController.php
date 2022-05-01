<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MetaSeoRender;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $viewData = [
            'meta_seo' => MetaSeoRender::setMetaSeo(['meta_title' => 'ログイン'])
        ];
        return view('pages.auth.login')->with($viewData);
    }

    protected function authenticated(Request $request, $user)
    {
        return $request->wantsJson()
            ? $this->json([], 'login success')
            : redirect()->intended($this->redirectPath());
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => User::ACTIVE]);
    }

    protected function guard()
    {
        return Auth::guard('user');
    }
}
