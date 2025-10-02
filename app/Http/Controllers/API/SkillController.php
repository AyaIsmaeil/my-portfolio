<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skill=Skill::all();
        return response()->json([
            'status'  => true,
            'message' => 'Skill List',
            'data'    => $skill
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|string|max:50',
            'percentage'=>'required|integer',
            'user_id'=>'required|exists:users,id'
        ]);

        $skill=Skill::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Skill created successfully!',
            'data'    => $skill
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        $skill=Skill::find($skill->id);
        return response()->json([
            'status'  => true,
            'message' => 'Skill List',
            'data'    => $skill
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $data=$request->validate([
            'name'=>'sometimes|required|string|max:50',
            'percentage'=>'sometimes|required|integer',
        ]);

        $skill->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Skill updated successfully!',
            'data'    => $skill
        ]);
    }


    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->json([
            'message' => 'Skill deleted successfully',
        ]);
    }
}
