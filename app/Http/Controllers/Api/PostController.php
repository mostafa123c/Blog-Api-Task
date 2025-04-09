<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user:id,name')->latest()->get();
        return $this->success([
            'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();

        $post = Post::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => Auth::id(),
        ]);

        return $this->success([
            'post' => $post->load('user:id,name'),
        ], 'Post created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->success([
            'post' => $post->load('user:id,name'),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $data = $request->validated();

        $post->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);

        $post->refresh();

        return $this->success([
            'post' => $post->load('user:id,name'),
        ], 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return $this->success([], 'Post deleted successfully');
    }
}
