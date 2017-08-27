<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

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
            'email'
        ]));

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $filename = uniqid() . "." . $request->file('avatar')->extension();
            $request->photo->storeAs('public', $filename);
            $user->avatar = $filename;
            $user->save();
        }

        return response()->json();
    }
}
