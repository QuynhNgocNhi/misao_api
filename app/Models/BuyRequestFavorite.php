<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyRequestFavorite extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'buy_request_favorites';
    protected $fillable = [
        'buy_request_id',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Car::class, 'buy_request_id');
    }
}
