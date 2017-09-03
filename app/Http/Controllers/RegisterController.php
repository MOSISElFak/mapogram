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

        //\Log::info($request->all());

        $filename = uniqid() . ".jpg";
        $base64_str = substr($request->input('img'), strpos($request->input('img'), ",")+1);
        $image = base64_decode($base64_str);
        file_put_contents(public_path('avatars/' . $filename),$image);

        $request->merge([
            "avatar" => $filename,
            "phone_number" => $request->get('phone')
        ]);

        User::create($request->only(['username', 'email', 'password', 'avatar', 'first_name', 'last_name', 'phone_number']));

        return response()->json(['message' => 'success']);
    }
}
