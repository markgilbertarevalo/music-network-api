<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\ImageService;
use App\Services\PostService;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PostService $postService)
    {
        try{
            return $postService->fetchPosts();
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong in PostsController.index',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Post\StorePostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $request, PostService $postService)
    {
        try{
            return $postService->store($request);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong in PostsController.store',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id, PostService $postService)
    {
        try{
            return $postService->fetchPostByID($id);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong in PostsController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Post\UpdatePostRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, int $id, PostService $postService)
    {
        try{
            return $postService->update($request, $id);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong in PostsController.update',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id, PostService $postService)
    {
        try{
            return $postService->delete($id);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong in PostsController.destroy',
                'error' => $e->getMessage()
            ], 400);
        } 
    }
}
