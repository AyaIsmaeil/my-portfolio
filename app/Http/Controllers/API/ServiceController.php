<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

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
        $data['title']=Purifier::clean($data['title'], 'default');
        $data['description']=Purifier::clean($data['description'], 'default');
        

        $service=Service::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Service created successfully!',
            'data'    => $service
        ], 201);
    }


    public function show(Service $service)
    {
        
        return response()->json([
            'status'  => true,
            'message' => 'Service List',
            'data'    => $service
        ]);
    }



    public function update(Request $request, Service $service)
    {
        $data=$request->validate([
            'title'=>'sometimes|required|string|max:50',
            'description'=>'sometimes|required|string',
        ]);
        if (isset($data['title'])) {
            $data['title'] = Purifier::clean($data['title'], 'default');
        }
        if (isset($data['description'])) {
            $data['description'] = Purifier::clean($data['description'], 'default');
        }

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
            'status' => true,
            'message' => 'Service deleted successfully',
            'data' => null
        ], 200);
    }
}
