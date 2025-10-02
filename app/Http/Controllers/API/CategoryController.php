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


    public function show($id)
    {
        $category=Category::find($id);
        return response()->json([
            'status'  => true,
            'message' => 'Category List',
            'data'    => $category
        ], 200);
    }

    public function update(Request $request, Category $category)
    {
        $data=$request->validate([
            'name'=>'required|string',
        ]);

        $category->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Category updated successfully!',
            'data'    => $category
        ], 200);
    }

    public function destroy(Category $category)
    {
        if(!$category){
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
