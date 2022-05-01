<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProductMediaRequest extends FormRequest
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
            'files'   => 'required|array',
            'files.*' => 'image',
        ];
    }

    public function attributes()
    {
        return [
            'files.*' => 'Hình ảnh'
        ];
    }

    public function messages()
    {
        return [
            'files.*.max' => 'Hình ảnh phải là tệp có dung lượng từ 3MB trở xuống. ..'
        ];
    }
}
