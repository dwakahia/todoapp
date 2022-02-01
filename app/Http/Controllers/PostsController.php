<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class PostsController extends Controller
{


    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://jsonplaceholder.typicode.com']);
    }

    public function showPosts()
    {

        return view('posts.posts');
    }

    public function getPosts()
    {

        $result = $this->client->request('GET', '/posts');

        return response($result->getBody());
    }

    public function createPost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'userId' => 'required'
        ]);


        $result = $this->client->request('POST', '/posts', [
            'form_params' => [
                'title' => $request->title,
                'body' => $request->body,
                'userId' => $request->userId
            ]
        ]);


        return $result->getBody();
    }

    public function updatePost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'userId' => 'required',
            'id' => 'required'
        ]);


        $result = $this->client->request('PUT', '/posts/' . $request->id, [
            'form_params' => [
                'title' => $request->title,
                'body' => $request->body,
                'userId' => $request->userId
            ]
        ]);

        return response($result->getBody());
    }

    public function deletePost($id)
    {

        $result = $this->client->request('DELETE', '/posts/' . $id);

        return response($result->getBody());

    }
}
