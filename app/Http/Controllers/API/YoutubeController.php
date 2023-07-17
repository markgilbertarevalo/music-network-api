<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Youtube\StoreYoutubeRequest;
use App\Models\Youtube;
use App\Services\YoutubeService;

class YoutubeController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Youtube\StoreYoutubeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreYoutubeRequest $request, YoutubeService $youtubeService)
    {
        try{
            return $youtubeService->store($request);
        }catch(\Exception $e){
            return response()->json([
                'messages'=> 'Something went wrong in YoutubeController.store',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $user_id, YoutubeService $youtubeService)
    {
        try{
            return $youtubeService->show($user_id);
        }catch(\Exception $e){
            return response()->json([
                'messages'=> 'Something went wrong in YoutubeController.store',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id, YoutubeService $youtubeService)
    {
        try{
            return $youtubeService->destroy($id);
        }catch(\Exception $e){
            return response()->json([
                'messages'=> 'Something went wrong in YoutubeController.destroy',
                'error' => $e->getMessage()
            ]);
        }
    }
}
