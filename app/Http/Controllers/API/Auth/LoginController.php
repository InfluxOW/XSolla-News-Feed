<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (! Auth::attempt($request->validated())) {
            return ['message' => 'Invalid Credentials'];
        }

        $accessToken = Auth::user()->createToken('access_token')->accessToken;

        return ['user' => Auth::user(), 'access_token' => $accessToken];

    }
}
