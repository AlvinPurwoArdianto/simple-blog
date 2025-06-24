<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List Categories',
            'data' => $categories,
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
            'name' => 'required|unique:categories',
            'slug' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error validation',
                'data' => $validate->errors(),
            ], 422);
        }

        try {
            $categories = new Categories;
            $categories->name = $request->name;
            $categories->slug = $request->slug;
            $categories->save();

            return response()->json([
                'success' => true,
                'message' => 'category added succesfully',
                'data' => $categories,
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
            $categories = Categories::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail category',
                'data' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'category not found',
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
            'name' => 'required',
            'slug' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error validation',
                'data' => $validate->errors(),
            ], 422);
        }

        try {
            $categories = Categories::findOrFail($id);

            $categories->name = $request->name;
            $categories->slug = $request->slug;
            $categories->save();

            return response()->json([
                'success' => true,
                'message' => 'category update succesfully',
                'data' => $categories,
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
            $categories = Categories::findOrFail($id);
            $categories->delete();
            return response()->json([
                'success' => true,
                'message' => 'category ' . $categories->name . ' remove succesfully ',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'category not found',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }
}
