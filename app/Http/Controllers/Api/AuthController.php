<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\loginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('token')->plainTextToken;


        return $this->success([
            'token' => $token,
            'user' => $user,
        ], 'User registered successfully', 201);
    }

    public function login(loginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return $this->error('Invalid credentials', 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return $this->success([
            'token' => $token,
            'user' => $user,
        ], 'User logged in successfully');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success([], 'User logged out successfully');
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return $this->success([
            'user' => $user,
        ], 'User retrieved successfully');
    }
}
