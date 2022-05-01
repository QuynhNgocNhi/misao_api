<?php

namespace App\Http\Controllers\Api\User\Auth;
;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends \App\Http\Controllers\Auth\ForgotPasswordController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $this->json(['message' => trans($response)], trans($response));
    }

}
