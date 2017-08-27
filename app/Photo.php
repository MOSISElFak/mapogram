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

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

}
