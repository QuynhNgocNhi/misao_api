<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMedia extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'user_medias';
    protected $fillable = [
        'user_id',
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
