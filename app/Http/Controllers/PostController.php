<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Resources\ItemCollection;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['user', 'category'])->paginate(10);

        return $this->sendResponse($posts, 'Posts retrieved successfully.');
    }


    public function getPostsByCategoryId(int $categoryId)
    {
        $posts = Post::with('user', 'category')->where('category_id', $categoryId)->paginate(10);

        return $this->sendResponse($posts, 'Posts with categoryId retrieved successfully.');
    }

    public function getPostsByUserId(int $userId)
    {
        $posts = Post::with('user', 'category')->where('user_id', $userId)->paginate(10);

        return $this->sendResponse($posts, 'Posts with categoryId retrieved successfully.');
    }


    public function search(Request $request)
    {
        $search = $request->search;

        if ($request->has('search')) {
            return $this->sendResponse(Post::with('user', 'category')->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')->paginate(10), 'posts found');
        } else {
            return $this->sendResponse(Post::with('user', 'category')->paginate(10), 'posts found');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $validator = Validator::make($data, [
            'title' => 'required|max:50',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        };

        return $this->sendResponse(Post::create($data), 'Post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $this->sendResponse(new PostResource($post), 'Post retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required|max:50',
            'body' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $post->title = $input['title'];
        $post->body = $input['body'];
        if (isset($input['category_id'])) {
            $post->category_id = $input['category_id'];
        }
        $post->save();

        return $this->sendResponse(new PostResource($post), 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return $this->sendResponse([], 'Post deleted successfullyl');
    }
}
