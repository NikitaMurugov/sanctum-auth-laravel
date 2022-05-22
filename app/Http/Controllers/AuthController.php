<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register new user
     *
     * @param Request $request
     * @return AuthResource
     */
    public function register(Request $request): AuthResource
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|confirmed',
        ]);
        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);
        return new AuthResource($user);
    }/**
     * Register new user
     *
     * @param Request $request
     * @return AuthResource|Application|ResponseFactory|Response
 */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|exists:users,email',
            'password' => 'required',
        ]);
        // Check email
        $user = User::where('email',$credentials['email'])->first();

        // Check password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        return new AuthResource($user);
    }

    /**
     * Logout user
     *
     * @return string[]
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out',
        ];
    }
}
