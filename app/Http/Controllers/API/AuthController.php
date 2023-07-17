<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, UserService $userService)
    {
        try {

            $user = $userService->store($request);
            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 200);

        } catch (\Exception $e) { 
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.register'
            ]);
        }
    }

    public function login(LoginRequest $request, UserService $userService)
    {
        try {

            return $userService->authenticateUser($request);
            
        } catch (\Exception $e) { 
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.login'
            ]);
        }
    }

    public function logout(LogoutRequest $request, UserService $userService)
    {
        try {

            return $userService->logoutUser($request->input('user_id'));
            
        } catch (\Exception $e) { 
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.logout'
            ]);
        }
    }
}
