<?php

namespace App\Http\Controllers\API;

use App\Models\About;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{

    public function index()
    {
        $about=About::first();
        return response()->json([
            'status'  => true,
            'message' => 'About List',
            'data'    => $about
        ], 200);
    }

    public function store(Request $request){

        $validated=$request->validate([
            'title'=>'required|string|max:50',
            'subtitle'=>'required|string|max:50',
            'description'=>'required|string',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cv'=>'nullable|string',
            'linkedin'=>'nullable|url',
            'github'=>'nullable|url',
            'facebook'=>'nullable|url',
            'instagram'=>'nullable|url',
            'user_id' => 'required|exists:users,id',
        ]);
        if($request->hasFile('cv')){
            $path=$request->file('cv');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('cv'),$name);
            $data['cv']=$name;
            
        }
        if($request->hasFile('image')){
            $path=$request->file('image');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('images'),$name);
            $data['image']=$name;
        }

        $about=About::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'description' => $validated['description'],
            'linkedin' => $validated['linkedin'] ?? null,
            'github' => $validated['github'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'user_id' => $validated['user_id'],
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'About created successfully!',
            'data'    => $about
        ], 201);

    }
    public function update(Request $request, About $about)
    {
        $data=$request->validate([
            'title'=>'required|string|max:50',
            'subtitle'=>'required|string|max:50',
            'description'=>'required|string',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cv'=>'nullable|string',
            'linkedin'=>'nullable|string',
            'github'=>'nullable|string',
            'facebook'=>'nullable|string',
            'instagram'=>'nullable|string',
            'user_id'=>'required|exists:users,id',
        ]);

        if($request->hasFile('image')){
            $path=$request->file('image');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('images'),$name);
            $data['image']=$name;
        }

        if($request->hasFile('cv')){
            $path=$request->file('cv');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('cv'),$name);
            $data['cv']=$name;
        }

        $about->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'About updated successfully!',
            'data'    => $about
        ], 200);
    }

    public function destroy($id)
    {
        $about=About::find($id);
        $about->delete();
        return response()->json([
            'message' => 'About deleted successfully',
        ]);
    }
}
