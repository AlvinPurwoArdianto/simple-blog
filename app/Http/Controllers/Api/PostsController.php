<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::with('category', 'user')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List post',
            'data' => $post,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|unique:posts',
            'slug' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|max:2048',
            'category_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error validation',
                'data' => $validate->errors(),
            ], 422);
        }

        try {
            $path = $request->file('thumbnail')->store('public/thumbnail');
            $post = new Post();
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->content = $request->content;
            $post->thumbnail = $path;
            $post->category_id = $request->category_id;
            $post->user_id = $request->user_id;
            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'post added succesfully',
                'data' => $post,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail post',
                'data' => $post,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'post not found',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|unique:posts',
            'slug' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|max:2048',
            'category_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error validation',
                'data' => $validate->errors(),
            ], 422);
        }

        try {
            $post = Post::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                Storage::delete($post->thumbnail); //menghapus gambar lama / foto lama
                $path = $request->file('thumbnail')->store('public/thumbnail');
                $post->thumbnail = $path;
            }

            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->content = $request->content;
            $post->category_id = $request->category_id;
            $post->user_id = $request->user_id;
            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'category update succesfully',
                'data' => $post,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            Storage::delete($post->thumbnail); //menghapus gambar lama / foto lama
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $post->title . ' remove successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'post not found',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }
}
