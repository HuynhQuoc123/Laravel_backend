<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Resources\ContactResource;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {

        $contacts = Contact::with(['ward.district.city'])
                ->whereHas('customer', function($query) use ($userId) {
                    $query->where('id', $userId);
                })
                ->get();

        return response(ContactResource::collection($contacts));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($userId, Request $request)
    {
        $contact = new Contact;
        $contact->customer_id = $userId;
        $contact->ward_id = $request->ward_id;
        $contact->address = $request->address;
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->save();
        return response()->json(['success'=>'true'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contactId)
    {
        $contact = Contact::find($contactId);
        $contact->update($request->all());
        return response()->json(['success' => 'true'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($contactId)
    {
        // $contact = Contact::find($contactId);
        // $contact->delete();
        // return response()->json(['success'=>'true'], 200);        
    }
}
