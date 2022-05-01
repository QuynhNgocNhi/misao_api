<?php

namespace App\Http\Requests\User;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password'      => ['bail', 'required', new MatchOldPassword()],
            'password'              => 'bail|required|min:8',
            'password_confirmation' => 'bail|required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'current_password.password' => 'Mật khẩu hiện tại không chính xác.',
        ];
    }


}
