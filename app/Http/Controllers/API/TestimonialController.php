<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{

    public function index()
    {
        $testimonial=Testimonial::all();
        return response()->json([
            'status'  => true,
            'message' => 'Testimonial List',
            'data'    => $testimonial
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|string|max:50',
            'job'=>'required|string',
            'message'=>'required|string',
            'rating'=>'required|integer',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if($request->hasFile('image')){
            $path=$request->file('image');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('testimonials'),$name);
            $data['image']=$name;
        }
        $testimonial=Testimonial::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Testimonial created successfully!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        $testimonial=Testimonial::find($testimonial->id);
        return response()->json([
            'status'  => true,
            'message' => 'Testimonial List',
            'data'    => $testimonial
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name'=>'sometimes|required|string|max:50',
            'job'=>'sometimes|required|string',
            'message'=>'sometimes|required|string',
            'rating'=>'sometimes|required|integer',
            'image'=>'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if($request->hasFile('image')){
            $path=$request->file('image');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('testimonials'),$name);
            $request['image']=$name;
        }

        $testimonial->update($request->all());
        return response()->json([
            'status'  => true,
            'message' => 'Testimonial updated successfully!',
        ]);
        
    }


    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response()->json([
            'message' => 'Testimonial deleted successfully',
        ]);
        
    }
}
