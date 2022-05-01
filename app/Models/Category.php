<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'image_path',
        'sort',
        'status',
    ];
    protected $appends = [
        'image_path_full'
    ];
    public function getImagePathFullAttribute()
    {
        return asset($this->image_path);
    }
}
