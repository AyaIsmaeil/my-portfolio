<?php

namespace App\Http\Controllers\API;

use App\Models\About;

use Illuminate\Http\Request;
use App\Http\Requests\AboutRequest;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;


class AboutController extends Controller
{
    private function uploadFile($file, $folder){
        $name = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $name);
        return $name;
    }

    public function index()
    {
        $about=About::first();
        return response()->json([
            'status'  => true,
            'message' => 'About List',
            'data'    => $about
        ], 200);
    }


    public function store(AboutRequest $request){

        $data=$request->validated();

        $data['title'] = Purifier::clean($data['title'], 'default');
        $data['subtitle'] = Purifier::clean($data['subtitle'], 'default');
        $data['description'] = Purifier::clean($data['description'], 'default');


        if($request->hasFile('cv')){
            $data['cv']=$this->uploadFile($request->file('cv'), 'cv');

        }
        if($request->hasFile('image')){
            $data['image']=$this->uploadFile($request->file('image'), 'images');
        }
        

        $about=About::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'About created successfully!',
            'data'    => $about
        ], 201);

    }
    public function update(AboutRequest $request, About $about)
    {
        $data=$request->validated();
        
        if (isset($data['title'])) {
            $data['title'] = Purifier::clean($data['title'], 'default');
        }

        if (isset($data['subtitle'])) {
            $data['subtitle'] = Purifier::clean($data['subtitle'], 'default');
        }

        if (isset($data['description'])) {
            $data['description'] = Purifier::clean($data['description'], 'default');
        }
        if($request->hasFile('image')){
            if ($about->image) {
                @unlink(public_path('images/' . $about->image));
            }
            $data['image']=$this->uploadFile($request->file('image'), 'images');
        }

        if($request->hasFile('cv')){
            if ($about->cv) {
                @unlink(public_path('cv/' . $about->cv));
            }
            $data['cv']=$this->uploadFile($request->file('cv'), 'cv');
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
        if ($about->image) 
            @unlink(public_path('images/' . $about->image));
        if ($about->cv) 
            @unlink(public_path('cv/' . $about->cv));
        $about->delete();
        return response()->json([
            'message' => 'About deleted successfully',
        ]);
    }
}
