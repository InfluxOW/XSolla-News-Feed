<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        dd($user);

        $accessToken = $user->createToken('access_token')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }
}
