<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\ImageService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    
     /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id, UserService $userService)
    {
        try {
            $user = $userService->fetchUser($id);
            return response()->json(['user' => $user], 200);
        } catch ( \Exception $e ) {
            return response()->json([
                'message' => 'Something went wrong in UsersController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\UpdateUserRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id, UserService $userService)
    {
        try {
            $user = $userService->fetchUser($id);
            
            if($request->hasFile('image')){
                (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            }

            $userService->updateData($request, $user);

            return response()->json('User details updated', 200);
        } catch ( \Exception $e ) {
            return response()->json([
                'message' => 'Something went wrong in UsersController.update',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
