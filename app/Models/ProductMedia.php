<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_medias';
    protected $fillable = [
        'product_id',
        'url'
    ];
    protected $appends = [
        'url_full'
    ];
    public function getUrlFullAttribute()
    {
        return asset($this->url);
    }
}
