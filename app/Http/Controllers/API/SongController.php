<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Song\StoreSongRequest;
use App\Models\Song;
use App\Models\User;
use App\Services\SongService;

class SongController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Song\StoreSongRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSongRequest $request, SongService $songService)
    {
        try{
            // $file = $request->file;

            // if(empty($file)){
            //     return response()->json('No song uploaded', 400);
            // }

            // $user = User::findOrFail($request->get('user_id'));

            // $song = $file->getClientOriginalName();
            // $file->move('songs/' . $user->id, $song);
            
            // Song::create([
            //     'user_id' => $request->get('user_id'),
            //     'title' => $request->get('title'),
            //     'song' => $song
            // ]);

            // return response()->json('Song Saved!', 200);

            return $songService->createSong($request);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something wrong in SongController.store',
                'error' => $e->getMessage()
            ], 400);
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id, int $user_id, SongService $songService)
    {
        try{
            // $song =Song::findOrFail($id);

            // $currentSong = public_path() . "/songs/" . $user_id . "/" . $song->song;
            // if(file_exists($currentSong)){ unlink($currentSong); }
            
            // $song->delete();

            // return response()->json('Song deleted', 200);

            return $songService->deleteSong($id, $user_id);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong in SongController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
