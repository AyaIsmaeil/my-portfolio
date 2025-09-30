<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //show all message (admin )
        $contact=Contact::all();
        return response()->json([
            'status'  => true,
            'message' => 'Contact List',
            'data'    => $contact
        ], 200);
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'sender_name'=>'required|string|max:50',
            'sender_email'=>'required|email',
            'project'=>'nullable|string|max:255',
            'message'=>'required|string',
            'user_id'=>'required|exists:users,id'
        ]);

        $contact=Contact::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Your message has been sent successfully!',
            'data'    => $contact
        ], 201);    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $message=Contact::find($id);
        return response()->json([
            'status'  => true,
            'message' => 'Contact List',
        ], 200);
    }


    public function update(Request $request, $id){
           $contact=Contact::find($id);

           if(!$contact){
            return response()->json([
                'message' => 'Contact not found',
            ],404);
           }


           $data=$request->validate([
            'status' => 'required|in:read,unread',
           ]);

           $contact->update($data);
           return response()->json([
            'message' => 'Contact updated successfully',
            'data' => $contact
           ],200);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json([
            'message' => 'Contact deleted successfully',
        ], 200);
    }

}
