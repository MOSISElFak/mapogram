<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $this->validate($request, [
            'username' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed'
        ]);

        User::create($request->only(['username', 'email', 'password']));

        return response()->json(['message' => 'success']);
    }
}
