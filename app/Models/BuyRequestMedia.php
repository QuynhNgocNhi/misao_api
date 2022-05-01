<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyRequestMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'buy_request_medias';
    protected $fillable = [
        'buy_request_id',
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
