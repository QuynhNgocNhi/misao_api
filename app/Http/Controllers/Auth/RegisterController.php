<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MetaSeoRender;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Models\UserOtp;
use App\Providers\RouteServiceProvider;
use App\Traits\HasResponse;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends ApiController
{
    use HasResponse;



    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
        register as traitRegister;
    }

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $prefectures = $this->provinceService->getList();
        $viewData = [
            'meta_seo' => MetaSeoRender::setMetaSeo(['meta_title' => '無料会員登録']),
            'prefectures' => $prefectures
        ];
        return view('pages.auth.register')->with($viewData);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        if ($request->wantsJson() && !$request->confirm) {
            if (UserOtp::where(['phone' => $request->phone, 'otp' => $request->otp, 'status' => 0])->first()) {
                $this->validator($request->all())->validate();
                UserOtp::where(['phone' => $request->phone, 'otp' => $request->otp])->update(['status' => 1]);
                return $this->json([], 'success');
            } else {
                return $this->responseError('Otp invalid', ['otp' => 'Otp invalid']);
            }
        }
        return $this->traitRegister($request);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:12', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = (new User())->forceFill([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        $user->save();
        return $user;
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    protected function registered(Request $request, $user)
    {
        return $request->wantsJson()
            ? $this->json([], 'success')
            : redirect($this->redirectPath());
    }
}
