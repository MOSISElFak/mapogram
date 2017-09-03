<?php

namespace App;

use App\Support\SpatialModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SpatialModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function friends()
    {
        return $this->belongsToMany('App\User', 'friends', 'user1_id', 'user2_id');
    }

    public function getAvatarAttribute($value) {
        return $value ? asset('avatars/' . $value) : null;
    }

    public function photos() {
        return $this->hasMany('App\Photo', 'user_id', 'id');
    }
}
