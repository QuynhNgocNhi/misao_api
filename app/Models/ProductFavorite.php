<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFavorite extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_favorites';
    protected $fillable = [
        'product_id',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Car::class, 'product_id');
    }
}
