<?php

namespace App\Repositories;

use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class ChatMessageRepository extends BaseRepository {

    function modelName(): string
    {
        return ChatMessage::class;
    }

    public function filter(array $params): Builder
    {
        $query = parent::filter($params);

        if ($value = Arr::get($params, 'last_id', null)) {
            $query->where('id', '>', $value);
        }

        return $query;
    }

}
