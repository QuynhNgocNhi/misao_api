<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'address',
        'gender',
        'identity_card_number',
        'birthday',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'profile_image_url'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followed()
    {
        return $this->hasMany(\App\Models\UserFollow::class, 'followed_id', 'id');
    }

    public function following()
    {
        return $this->hasMany(\App\Models\UserFollow::class, 'following_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(\App\Models\Product::class, 'user_id', 'id')->with('images')
        ->with('order');
    }

    public function buyRequest()
    {
        return $this->hasMany(\App\Models\BuyRequest::class, 'user_id', 'id')->with('images')
        ->with('order');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getProfileImageUrlAttribute()
    {
        return asset($this->profile_image);
    }
}
