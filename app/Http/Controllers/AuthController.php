<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('LaravelAuthApp')->plainTextToken;
        event(new Registered($user));
        Auth::login($user);

        return response()->json(['token' => $token]);
    }

    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->validated())) {
            $token = auth()->user()->createToken('LaravelAuthApp')->plainTextToken;

            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function loginShow(): JsonResponse
    {
        return response()->json(['login please']);

    }
}
