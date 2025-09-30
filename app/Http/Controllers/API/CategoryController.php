<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category=Category::all();
        return response()->json([
            'status'  => true,
            'message' => 'Category List',
            'data'    => $category
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|string|max:50',
        ]);

        $category=Category::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Category created successfully!',
            'data'    => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category=Category::find($id);
        return response()->json([
            'status'  => true,
            'message' => 'Category List',
            'data'    => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data=$request->validate([
            'name'=>'required|string|max:50',
        ]);

        $category->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Category updated successfully!',
            'data'    => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
