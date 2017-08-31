<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Image;

class PhotosController extends Controller
{
    /**
     * @param string $location - lng,lat (31.xxx,56.xxx)
     * @param $distance - in METERS
     */
    public function getPhotosInRadius($location, $distance)
    {
        $photos = Photo::distance($distance, $location)->get();

        return response()->json($photos);
    }

    public function postPhoto(Request $request)
    {
        $this->validate($request, [
            'img' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        $filename = uniqid() . ".jpg";
        Image::make($request->input('img'))->save(public_path('images/' . $filename));

        $photo = new Photo([
            'user_id'     => auth()->user()->id,
            'filename'    => $filename,
            'location'    => trim($request->input('lng')) . "," . trim($request->input('lat')),
            'description' => $request->input('description'),
            'categories' => $request->input('categories')
        ]);

        $photo->save();

        return response()->json(['message' => 'success']);
    }

}
