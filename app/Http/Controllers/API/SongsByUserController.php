<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\User;
use App\Services\SongService;

class SongsByUserController extends Controller
{   
    /**
     * Display a listing of the resource.
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $user_id, SongService $songService)
    {
        try{
            return $songService->fetchSongByUser($user_id);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong in SongsByUserContoller.index',
                'error' => $e->getMessage()
            ], 400);
        }
    }

}
