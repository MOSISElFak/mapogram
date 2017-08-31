<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
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

    public function photo() {
        return $this->belongsTo('App\Photo', 'photo_id');
    }
}
