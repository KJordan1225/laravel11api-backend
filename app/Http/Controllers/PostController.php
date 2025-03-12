<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;


class PostController extends Controller implements HasMiddleware
{
    public static function middleware ()
    {
        return [
            new Middleware( 'auth:sanctum', except: ['index' , 'show'])
        ];
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::with('user' )->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate ([
            'title' => 'required | max:255',
            'body' => 'required'
            ]);

        $post = $request->user()->posts()->create($fields);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'user' => $post->user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return ['success' => true, 'post' => $post, 'user' => $post->user];
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Gate::authorize('modify', $post);

        if (Gate::denies('modify', $post)) {
            abort(403, 'You do not own this post.');
        }
    
        
        $fields = $request->validate ([
            'title' => 'required | max:255',
            'body' => 'required'
            ]);        

        $post->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'post' => $post
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Gate::authorize('modify', $post);

        if (Gate::denies('modify', $post)) {
            abort(403, 'You do not own this post.');
        }
        
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully',
        ]);
    }
    
}
