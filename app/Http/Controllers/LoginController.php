<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only(['username', 'password']))) {
            $user = User::where('username', $request->input('username'))->first();
            $token = $this->generateAuthToken();
            $user->api_token = $token;
            $user->save();

            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Wrong username and/or password.'], 422);
        }

    }

    public function logout(Request $request) {
        $user = Auth::user();
        $user->api_token = null;
        $user->save();

        return response()->json();
    }

    private function generateAuthToken() {
        return str_random(60);
    }
}
