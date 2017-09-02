<?php

namespace App\Support;

use DB;

/**
 * Class SpatialModel
 *
 *
 * @package App\Support
 */
trait SpatialModel
{
    protected $geofields = ['location'];

    public function setLocationAttribute($value) {
        $this->attributes['location'] = DB::raw("POINT($value)");
    }

    public function getLocationAttribute($value){

        $loc =  substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);

        return substr($loc,0,-1);
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach($this->geofields as $column){
            $raw .= ' astext('.$column.') as '.$column.' ';
        }

        return parent::newQuery($excludeDeleted)->addSelect('*',DB::raw($raw));
    }

    public function scopeDistance($query, $dist, $location, $categories = null)
    {
        $r = $query->whereRaw('st_distance_sphere(location,POINT('.$location.')) < '.$dist);
        $categories = explode(",", $categories);

        $r->where(function ($q) use ($categories) {
            foreach ($categories as $cat) {
                $q->orWhere("categories", 'like', "%" . $cat ."%");
            }
        });

        return $r;
    }
}