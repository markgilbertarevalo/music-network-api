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
            // $yt = new Youtube;

            // $yt->user_id = $request->get('user_id');
            // $yt->title = $request->get('title');
            // $yt->url = env("YT_EMBED_URL") . $request->get('url') . "?autoplay=0";

            // $yt->save();

            // return response()->json('New Youtube link saved.', 200);
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
            // $videosByUser = Youtube::where('user_id', $user_id)->get();

            // return response()->json(['videos_by_user' => $videosByUser], 200);

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
            // $yt = Youtube::findOrFail($id);
            // $yt->delete();

            // return response()->json('Youtube Video deleted.', 200);

            return $youtubeService->destroy($id);
        }catch(\Exception $e){
            return response()->json([
                'messages'=> 'Something went wrong in YoutubeController.destroy',
                'error' => $e->getMessage()
            ]);
        }
    }
}
