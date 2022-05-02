<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatRoom extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'product_id',
        'buy_request_id',
        'order_id',
        'buyer_read_at',
        'seller_read_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chat_room_id');
    }

    public function last_message(): HasOne
    {
        return $this->hasOne(ChatMessage::class, 'chat_room_id')->orderBy('id', 'desc');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'buyer_id', 'id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'seller_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    public function buyRequest(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'buy_request_id', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id', 'id');
    }
}
