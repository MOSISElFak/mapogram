<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Image;
use Log;
use DB;

class PhotosController extends Controller
{

    public function getPhoto($id) {
        return Photo::with('comments.user')
            ->with('user')
            ->find($id);
    }

    public function addComment($id, Request $request) {
        $this->validate($request, [
            'text' => 'required',
        ]);

        Comment::create([
            'text' => $request->input('text'),
            'user_id' => auth()->user()->id,
            'photo_id' => $id
        ]);

        return response()->json(['message' => 'success']);
    }

    /**
     * @param string $location - lng,lat (31.xxx,56.xxx)
     * @param $distance - in METERS
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPhotosInRadius($location, $distance, $categories = null)
    {

        Log::info($categories);
        $photos = Photo::distance($distance, $location, $categories)
            ->orderBy('id', 'ASC')
            ->get();

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
        //Image::make($request->input('img'))->save(public_path('images/' . $filename));

        $base64_str = substr($request->input('img'), strpos($request->input('img'), ",")+1); // get the image code
        $image = base64_decode($base64_str); // decode the image
        file_put_contents(public_path('images/' . $filename),$image); // move the image to the desired path with desired name and extension

        Log::info($request->input("lng"));
        Log::info($request->input("lat"));
        DB::insert("INSERT INTO `photos` (user_id, filename, location, description, categories, created_at, updated_at) values (?, ?, POINT($request->input('lng'),$request->input('lat')), ?, ?, ?, ?)", [
            auth()->user()->id, $filename, $request->input('description'), $request->input('categories')
        ]);

        /*$photo = new Photo([
            'user_id'     => auth()->user()->id,
            'filename'    => $filename,
            'location'    => trim($request->input('lng')) . "," . trim($request->input('lat')),
            'description' => $request->input('description'),
            'categories' => $request->input('categories')
        ]);

        $photo->save();*/

        return response()->json(['message' => 'success']);
    }

    public function likePhoto($id)
    {
        Photo::whereId($id)->increment('likes');
        return response()->json(['message' => 'success']);
    }

}
