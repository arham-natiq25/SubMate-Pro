<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    function __invoke()
    {
        $newToken = auth()->refresh();
        return response()->json([
            'status'=>true,
            'message'=>'New Access Token generated',
            'token'=>$newToken
        ]);
    }
}
