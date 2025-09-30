<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{

    public function index()
    {
        $education=Education::all();
        return response()->json([
            'status'  => true,
            'message' => 'Education List',
            'data'    => $education
        ], 200);
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'degree'=>'required|string|max:50',
            'institution'=>'required|string|max:50',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
        ]);

        $education=Education::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Education created successfully!',
            'data'    => $education
        ], 201);
    }

    public function show(Education $education)
    {
        $education=Education::find($education->id);
        return response()->json([
            'status'  => true,
            'message' => 'Education List',
            'data'    => $education
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        $data=$request->validate([
            'degree'=>'required|string|max:50',
            'institution'=>'required|string|max:50',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
        ]);

        $education->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Education updated successfully!',
            'data'    => $education
        ], 200);
    }


    public function destroy(Education $education)
    {
        $education->delete();
        return response()->json([
            'message' => 'Education deleted successfully',
        ], 200);
    }
}
