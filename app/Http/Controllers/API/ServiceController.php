<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service=Service::all();
        return response()->json([
            'status'  => true,
            'message' => 'Service List',
            'data'    => $service
        ], 200);
    }


    public function store(Request $request)
    {
        $data=$request->validate([
            'title'=>'required|string|max:50',
            'description'=>'required|string',
            'user_id'=>'required|exists:users,id'
        ]);
        if($request->hasFile('icon')){
            $path=$request->file('icon');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('services'),$name);
            $data['icon']=$name;
        }
        

        $service=Service::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Service created successfully!',
            'data'    => $service
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $service=Service::find($service->id);
        return response()->json([
            'status'  => true,
            'message' => 'Service List',
            'data'    => $service
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data=$request->validate([
            'title'=>'required|string|max:50',
            'description'=>'required|string',
        ]);

        $service->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Service updated successfully!',
            'data'    => $service
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json([
            'message' => 'Service deleted successfully',
        ]);
    }
}
