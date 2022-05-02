<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model {
    use HasFactory, SoftDeletes;

    const TYPE_TEXT = 0;
    const TYPE_IMAGE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_room_id',
        'buyer_id',
        'seller_id',
        'content',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

    public function getContentAttribute($value)
    {
        if ($this->type == self::TYPE_IMAGE) {
            return url($value);
        }

        return $value;
    }

}
