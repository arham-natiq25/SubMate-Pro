<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    function __invoke()
    {
        $userData = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'profile data',
            'user' => $userData
        ]);
    }
}
