<?php

namespace App;

use App\Support\SpatialModel;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use SpatialModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'photo_id', 'id');
    }
}
