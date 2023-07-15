<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class UserService   
{
    public function fetchUser(int $id)
    {
        $user = User::findOrFail($id);

        return $user;  
    }

    public function updateData($request, $user)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->location = $request->location;
        $user->description = $request->description;

        $user->save();  
    }

    public function store($userData)
    {
        $auth = User::create($this->prepareRegData($userData));
        return $auth;
    }

    public function prepareRegData($userData)
    {
        $authData['first_name'] = $userData['first_name'];
        $authData['last_name'] = $userData['last_name'];
        $authData['email'] = $userData['email'];
        $authData['password'] = Hash::make($userData['password']);

        return $authData;
    }

    public function fetchUserWhereEmail($userData)
    {
        $user = User::where('email', '=', $userData['email'])->firstOrFail();

        return $user;
    }

    public function authenticateUser($userData)
    {
        //$user = $this->fetchUserWhereEmail($userData);

        if(Auth::attempt(['email'=>$userData['email'], 'password'=>$userData['password']]))
        {
            $token = Auth::user()->createToken('user_token')->plainTextToken;
            return response()->json([ 'user' => Auth::user(), 'token' => $token ], 200);
        }
        else{
            return response()->json([
                'error' => 'Something went wrong in login'
            ]);
        }
    }

    public function logoutUser($id)
    {
        $user = $this->fetchUser($id);

        $user->tokens()->delete();

        return response()->json('User logged out!', 200);
    }
    
}