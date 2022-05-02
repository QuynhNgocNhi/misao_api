<?php

namespace App\Http\Requests;

use App\Models\ChatRoom;
use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $roomId = $this->route('id');
        $chatRoom = ChatRoom::find($roomId);
        $userId = auth()->id();

        return $userId && ($chatRoom?->seller_id == $userId || $chatRoom?->buyer_id == $userId);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file'   => is_array($this->file('file')) ? 'nullable|max:6' : '',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif',
            'content' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
            'file.max' => '6枚以上の写真を送ることはできません。',
        ];
    }
}
