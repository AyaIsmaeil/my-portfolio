<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project=Project::all();
        return response()->json([
            'status'  => true,
            'message' => 'Project List',
            'data'    => $project
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'title'=>'required|string|max:50',
            'description'=>'required|string',
            'url'=>'required|url',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id'=>'required|exists:users,id',
            'category_id'=>'required|exists:categories,id'
        ]);

        $data['title'] = Purifier::clean($data['title'], 'default');
        $data['description'] = Purifier::clean($data['description'], 'default');  

        if($request->hasFile('image')){
            $path=$request->file('image');  
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('projects'),$name);   
            $data['image']=$name;         
        }



        $project=Project::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Project created successfully!',
            'data'    => $project
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return response()->json([
            'status'  => true,
            'message' => 'Project List',
            'data'    => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
       $data=$request->validate([
            'title'=>'sometimes|required|string|max:50',
            'description'=>'sometimes|required|string',
            'image'=>'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url'=>'sometimes|required|url',
    
       ]);
        if(isset($data['title'])){
            $data['title'] = Purifier::clean($data['title'], 'default');
        }

        if(isset($data['description'])){
            $data['description'] = Purifier::clean($data['description'], 'default');
        }

        if($request->hasFile('image')){
            if($project->image){
                @unlink(public_path('projects/'.$project->image));
            }
            $path=$request->file('image');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('projects'),$name);
            $data['image']=$name;
        }

        $project->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Project updated successfully!',
            'data'    => $project
        ]);
    }


    public function destroy(Project $project)
    {

    if ($project->image) {
        @unlink(public_path('projects/' . $project->image));
    }

        $project->delete();

        return response()->json([
            'status' => true,
            'message' => 'Project deleted successfully',
            'data' => null
        ], 200);
        }
}
