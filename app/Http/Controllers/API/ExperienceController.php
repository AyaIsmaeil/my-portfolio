<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experience=Experience::all();
        return response()->json([
            'status'  => true,
            'message' => 'Experience List',
            'data'    => $experience
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'role'=>'required|string|max:50',
            'company'=>'required|string|max:50',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'user_id'=>'required|exists:users,id'
        ]);
        $data['role'] = Purifier::clean($data['role'], 'default');
        $data['company'] = Purifier::clean($data['company'], 'default');

        $experience=Experience::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Experience created successfully!',
            'data'    => $experience
        ], 201);
    }

    public function show(Experience $experience)
    {
        $experience=Experience::find($experience);

        return response()->json([
            'status'  => true,
            'message' => 'Experience List',
            'data'    => $experience
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {
        $data=$request->validate([
            'role'=>'sometimes|required|string|max:50',
            'company'=>'sometimes|required|string|max:50',
            'start_date'=>'sometimes|required|date',
        ]);

        if(isset($data['role'])){
            $data['role'] = Purifier::clean($data['role'], 'default');
        }

        if(isset($data['company'])){
            $data['company'] = Purifier::clean($data['company'], 'default');
        }

        $experience->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Experience updated successfully!',
            'data'    => $experience
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        if(!$experience){
            return response()->json(['message' => 'not found'], 404);
        }
        $experience->delete();
        return response()->json([
            'message' => 'Experience deleted successfully',
        ], 200);
    }
}
