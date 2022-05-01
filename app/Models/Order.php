<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'status',
        'user_sell_id',
        'user_id',
        'product_id',
        'buy_request_id'
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


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function buyRequest(): BelongsTo
    {
        return $this->belongsTo(BuyRequest::class, 'buy_request_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_sell_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chat_room(): HasOne
    {
        return $this->hasOne(ChatRoom::class, 'order_id');
    }
}
