<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // get all comments of a post
    public function index($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        return response([
            'post' => $post->comments()->with('user:id,name,image')->get(),
        ], 200);
    }

    // create a comment
    public function store(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        return response([
            'post' => $post->comments()->with('user:id,name,image')->get(),
        ], 200);
    }
}
