<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiChatController;

class ChatController extends BaseApiChatController {

    protected function auth()
    {
        return auth('api');
    }

}
