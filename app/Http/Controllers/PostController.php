<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Return list of Posts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $posts = Post::with(['tags' => function ($q) {
            $q->select('id', 'name');
        }])->orderBy('id', 'DESC')->paginate($this->perPageParam($request));

        return response()->json($posts);
    }

    /**
     * Return details of 1 Post
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::with(['tags' => function($q) {
            $q->select('id', 'name');
        }])->find($id);

        return response()->json($post);
    }
}
