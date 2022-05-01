<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFollow extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_follows';
    protected $fillable = [
        'followed_id',
        'following_id'
    ];

    protected $casts = [
        'followed' => 'string',
        'following' => 'string',
    ];
    protected $appends = [
        'followed', 'following'
    ];

    public function getFollowedAttribute()
    {
        if (empty($this->followed_id)) return null;
        return User::where('id', $this->followed_id)
            ->first();
    }
    public function getFollowingAttribute()
    {
        if (empty($this->following_id)) return null;
        return User::where('id', $this->following_id)
            ->first();
    }
}
