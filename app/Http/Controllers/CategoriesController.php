<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;

class CategoriesController extends Controller
{
    public function all(){
        return DB::table('categories')->get();
    }
}
