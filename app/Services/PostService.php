<?php

namespace App\Services;

use App\Models\Post;
use App\Services\ImageService;

class PostService
{
    public function fetchPosts()
    {
        $postPerPage = 10;
        $post = Post::with('user')
            ->orderBy('updated_at', 'desc')
            ->simplePaginate($postPerPage);
        $pageCount = count(Post::all()) / $postPerPage;

        return response()->json([
            'paginate' => $post,
            'page_count' => ceil($pageCount),
        ], 200);
    }

    public function fetchPostByID($id)
    {
        $post = Post::with('user')->findOrFail($id);
    
        return response()->json($post, 200);
    }

    public function store($request)
    {
        if($request->hasFile('image') === false){
            return response()->json(['error' => 'There is no image to upload.'], 400);
        }

        $post = new Post;

        (new ImageService)->updateImage($post, $request, '/images/posts/', 'store');

        $post->title = $request->get('title');
        $post->location = $request->get('location');
        $post->description = $request->get('description');

        $post->save();

        return response()->json('New post created.', 200);
    }

    public function update($request, $id)
    {
        $post = $this->fetchPost($id);

        if($request->hasFile('image')){
            (new ImageService)->updateImage($post, $request, '/images/posts/', 'update');
        }

        $post->title = $request->get('title');
        $post->location = $request->get('location');
        $post->description = $request->get('description');

        $post->save();

        return response()->json('Post with id ' . $id . ' was updated!', 200);
    }

    public function fetchPost(int $id)
    {
        $post = Post::findOrFail($id);

        return $post;
    }

    public function delete($id)
    {
        $post = $this->fetchPost($id);

        if(!empty($post->image)){
            $currentImage = public_path() . '/images/posts/' . $post->image;

            if(file_exists($currentImage)){
                unlink($currentImage);
            }
        }

        $post->delete();

        return response()->json('Post deleted!', 200);
    }

    public function fetchByUser($user_id)
    {
        $posts = Post::where('user_id', $user_id)->get();

        return response()->json($posts, 200);
    }
}