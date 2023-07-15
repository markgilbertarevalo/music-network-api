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

            // $user = User::create([
            //     'first_name' => $request->input('first_name'),
            //     'last_name' => $request->input('last_name'),
            //     'email' => $request->input('email'),
            //     'password' => Hash::make($request->input('password'))
            // ]);
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

            // $user = User::where('email', '=', $request->input('email'))->firstOrFail();

            // if(Hash::check($request->input('password'), $user->password)){
            //     $token = $user->createToken('user_token')->plainTextToken;

            //     return response()->json([ 'user' => $user, 'token' => $token ], 200);
            // }

            // return response()->json([
            //     'error' => 'Something went wrong in AuthController.login'
            // ]);

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

            // $user = User::findOrFail($request->input('user_id'));

            // $user->tokens()->delete();

            // return response()->json('User logged out!', 200);

            return $userService->logoutUser($request->input('user_id'));
            
        } catch (\Exception $e) { 
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.logout'
            ]);
        }
    }
}
