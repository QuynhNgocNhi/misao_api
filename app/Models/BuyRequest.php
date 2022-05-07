<?php

namespace App\Models;

use App\Traits\HasModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BuyRequest extends Model
{
    use HasFactory, HasModel;
    protected $table = 'buy_requests';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'unit',
        'description',
        'discount',
        'is_active',
        'quantity',
        'limited_date',
        'name',
        'seller_name',
        'seller_address',
        'seller_phone'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
    protected $casts = [
        'category' => 'string',
        'user' => 'string'
    ];
    protected $appends = [
        'category', 'user'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    public function images(): HasMany
    {
        return $this->hasMany(\App\Models\BuyRequestMedia::class, 'buy_request_id');
    }

    public function order(): HasMany
    {
        return $this->hasMany(\App\Models\Order::class, 'buy_request_id');
    }

    public function categories(): HasOne
    {
        return $this->hasOne(\App\Models\Category::class, 'category_id');
    }

    public function favorite()
    {
        return $this->hasMany(\App\Models\BuyRequestFavorite::class, 'buy_request_id');
    }

    public function getCategoryAttribute()
    {
        if (empty($this->category_id)) return null;
        return Category::where('id', $this->category_id)
            ->first();
    }

    public function getUserAttribute()
    {
        if (empty($this->user_id)) return null;
        return User::where('id', $this->user_id)
            ->first();
    }
}
