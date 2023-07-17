<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;

class PostsByUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $user_id
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $user_id, PostService $postService)
    {
        try{
            return $postService->fetchByUser($user_id);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong in PostsByUserController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }

}
