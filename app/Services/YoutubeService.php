<?php

namespace App\Services;

use App\Models\Youtube;

class YoutubeService
{
    public function store($request)
    {
        $yt = new Youtube;

        $yt->user_id = $request->get('user_id');
        $yt->title = $request->get('title');
        $yt->url = env("YT_EMBED_URL") . $request->get('url') . "?autoplay=0";

        $yt->save();

        return response()->json('New Youtube link saved.', 200);
    }

    public function show($user_id)
    {
        $videosByUser = $this->fetchByUserId($user_id);

        return response()->json(['videos_by_user' => $videosByUser], 200);
    }

    public function fetchByUserId($user_id)
    {
        $videosByUser = Youtube::where('user_id', $user_id)->get();

        return $videosByUser;
    }

    public function fetchById($id)
    {
        $yt = Youtube::findOrFail($id);

        return $yt;
    }

    public function destroy($id)
    {
        $yt = $this->fetchById($id);
        $yt->delete();

        return response()->json('Youtube Video deleted.', 200);
    }
}