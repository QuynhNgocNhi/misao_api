<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    public function broker()
    {
        return Password::broker('admins');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function sendResetLinkResponse(Request $request, $response)
    {
        return view('admin.auth.passwords.password_request_complete');
    }
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    // public function showLinkRequestForm()
    // {
    //     return view('admin.auth.passwords.password_request')->with('user_type', request()->user_type);
    // }
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.password_request');
    }
}
