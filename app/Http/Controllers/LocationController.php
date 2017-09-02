<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class LocationController extends Controller
{
    /**
     * EXPECTS to receive user's location (lng,lat)
     * Responds with locations of friends (useful for polling)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function locationExchange(Request $request)
    {
        $this->validate($request, [
            'location' => 'required'
        ]);
        $user = auth()->user();


        $user->update([
            'location' => $request->input('location')
        ]);

        $user->friends();

        return response()->json($user->friends);
    }
}
