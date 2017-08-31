<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Image;
use DB;
use Log;

class UsersController extends Controller
{
    public function getUser($username) {
        $user = User::where('username', $username)->first();

        if ($user->avatar)
            $user->avatar = asset($user->avatar);

        return $user ? response()->json($user) : response()->json(['error' => 'user not found'], 404);
    }

    public function updateUser(Request $request, $username) {
        $user = User::where('username', $username)->first();

        if (!$user) return response()->json(['error' => 'user not found'], 404);

        $user->update($request->only([
            'username',
            'email',
            'phone_number',
            'email',
            'first_name',
            'last_name'
        ]));

        if ($request->input('avatar')) {
            $filename = uniqid() . ".jpg";
            Image::make($request->input('avatar'))->save(public_path('images/' . $filename));

            $user->avatar = $filename;
            $user->save();
        }

        return response()->json();
    }

    public function postBecomeFriend(Request $request, $username1, $username2)
    {
        $user1 = User::where('username', $username1)->first();
        $user2 = User::where('username', $username2)->first();

        if (!$user1 || !$user2) {
            return response()->json(['error' => 'no such users'], 400);
        }

        DB::insert([
            ['user1_id' => $user1->id, 'user2_id' => $user2->id],
            ['user1_id' => $user2->id, 'user2_id' => $user1->id],
        ]);

        return response()->json(['message' => 'success']);
    }

    public function topList() {
        return response()->json(
            Photo::join('users', 'users.id', '=', 'photos.user_id')
                ->groupBy('users.id')
                ->select(DB::raw('users.id, users.username, users.avatar, SUM(photos.likes) as total_likes'))
                ->orderBy('total_likes', 'desc')
                ->get()->toArray()
        );
    }
}
