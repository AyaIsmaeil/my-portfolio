<?php

namespace App\Http\Controllers\API;

use App\Models\Education;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mews\Purifier\Facades\Purifier;

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
            'user_id'=>'required|exists:users,id'
        ]);
        $data['degree'] = Purifier::clean($data['degree'], 'default');
        $data['institution'] = Purifier::clean($data['institution'], 'default');

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
            'degree'=>'sometimes|required|string|max:50',
            'institution'=>'sometimes|required|string|max:50',
            'start_date'=>'sometimes|required|date',
            'end_date'=>'sometimes|required|date',
            'user_id'=>'sometimes|required|exists:users,id'
        ]);
        $data['degree'] = Purifier::clean($data['degree'], 'default');
        $data['institution'] = Purifier::clean($data['institution'], 'default');

        $education->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Education updated successfully!',
            'data'    => $education
        ], 200);
    }


    public function destroy(Education $education)
    {
        if(!$education){
            return response()->json(['message' => 'not found'], 404);
        }
        $education->delete();
        return response()->json([
            'message' => 'Education deleted successfully',
        ], 200);
    }
}
