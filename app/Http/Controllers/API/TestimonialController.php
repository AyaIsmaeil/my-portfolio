<?php

namespace App\Http\Controllers\API;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;

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
            'user_id'=>'required|exists:users,id'

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
        $testimonial->refresh();
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
        $data=$request->validate([
            'name'=>'sometimes|required|string|max:50',
            'job'=>'sometimes|required|string|max:100',
            'message'=>'sometimes|required|string',
            'rating'=>'sometimes|required|integer|min:1|max:5',
            'image'=>'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (isset($data['name'])) {
            $data['name'] = Purifier::clean($data['name'], 'default');
        }
        if (isset($data['job'])) {
            $data['job'] = Purifier::clean($data['job'], 'default');
        }
        if (isset($data['message'])) {
            $data['message'] = Purifier::clean($data['message'], 'default');
        }


        if($request->hasFile('image')){
            if ($testimonial->image && file_exists(public_path('testimonials/'.$testimonial->image))) {
                unlink(public_path('testimonials/'.$testimonial->image));
            }
            $path=$request->file('image');
            $name=time().".".$path->getClientOriginalExtension();
            $path->move(public_path('testimonials'),$name);
            $data['image']=$name;
        }


        $testimonial->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Testimonial updated successfully!',
            'data'    => $testimonial
        ]);
        
    }


    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image && file_exists(public_path('testimonials/'.$testimonial->image))) {
            unlink(public_path('testimonials/'.$testimonial->image));
        }
        $testimonial->delete();
        return response()->json([
            'message' => 'Testimonial deleted successfully',
        ]);
        
    }
}
