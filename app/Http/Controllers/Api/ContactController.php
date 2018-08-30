<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contact as ContactResource;
use App\Contact;

class ContactController extends Controller
{
    public function __construct(){
        return $thiss->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        // return new ContactResource($contacts);
        return   ContactResource::collection($contacts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $contact= $request->user()->contacts()->create($request->all());
       return new ContactResource($contact);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $contact = Contact::find($id);
        return new ContactResource($contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        if(request()->user()->id !== $contact->user_id){
            return response()->json(['error'=>'Unauthorize eroor',401]);
        }
        $contact->update($request->all());
         return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $contact = Contact::find($id);
        if(request()->user()->id !== $contact->user_id){
            return response()->json(['error'=>'Unauthorize eroor',401]);
        }
         $contact= $contact->delete();
        //   $contacts = Contact::all();
        //  return  ContactResource::collection($contacts);
        return response()->json(null,200);
    }
}
