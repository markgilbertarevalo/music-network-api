<?php

namespace App\Services;

use App\Services\UserService;
use App\Models\Song;
//use App\Models\User;

class SongService
{
    public function __construct()
    { 
        $this->userService = new UserService();
    }

    public function createSong($request)
    {
        //$userService = new UserService;

        $file = $request->file;

        if(empty($file)){
            return response()->json('No song uploaded', 400);
        }

        $user = $this->userService->fetchUser($request->get('user_id'));

        $song = $file->getClientOriginalName();
        $file->move('songs/' . $user->id, $song);
        
        Song::create([
            'user_id' => $request->get('user_id'),
            'title' => $request->get('title'),
            'song' => $song
        ]);

        return response()->json('Song Saved!', 200);
    }

    public function fetchSong($id)
    {
        $song = Song::findOrFail($id);


        return $song;
    }

    public function deleteSong($id, $user_id)
    {
        $song = $this->fetchSong($id);

        $currentSong = public_path() . "/songs/" . $user_id . "/" . $song->song;
        if(file_exists($currentSong)){ unlink($currentSong); }
        
        $song->delete();

        return response()->json('Song deleted', 200);
    }

    public function fetchSongByUser($user_id)
    {
        $songs = [];
        $songs_by_user = Song::where('user_id', $user_id)->get();
        //$user = User::find($user_id);
        $user = $this->userService->fetchUser($user_id);

        foreach ($songs_by_user as $song) {
            array_push($songs, $song);
        }

        return response()->json([
            'artist_id' => $user_id,
            'artist_name' => $user->first_name . ' ' . $user->last_name,
            'songs' => $songs
        ], 200);
    }
}