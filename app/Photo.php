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

    protected $appends = ['url'];


    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'photo_id', 'id');
    }

    public function getUrlAttribute() {
        return asset('img/' . $this->filename);
    }
}
