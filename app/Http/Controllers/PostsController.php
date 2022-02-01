<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostsController extends Controller
{

    protected $BASE_URL = 'https://jsonplaceholder.typicode.com';

    public function showPosts()
    {
        return view('posts.posts');
    }

    public function getPosts()
    {
        $result = Http::get($this->BASE_URL . '/posts');

        return response($result->json());
    }

    public function createPost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'userId' => 'required'
        ]);

        $result = Http::post($this->BASE_URL . '/posts', $request->only('title', 'body', 'userId'));

        return response($result->json());
    }

    public function updatePost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'userId' => 'required',
            'id' => 'required'
        ]);

        $result = Http::put($this->BASE_URL . '/posts/' . $request->id, $request->only('title', 'body', 'userId'));

        return response($result->json());
    }

    public function deletePost($id)
    {
        $result = Http::delete($this->BASE_URL . '/posts/' . $id);

        return response($result->json());

    }
}
