<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomingRequest;
use App\Models\Incoming;
use App\Models\User;
use Illuminate\Http\Request;

class IncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Incoming::orderBy('date','DESC')->get();
        return view("incoming.index", ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('incoming.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncomingRequest $request)
    {
        $validator = $request->validated();
        if (!empty($validator->errors)) {
            return back()->withErrors($validator)->withInput();
        }
        Incoming::create([
            'desc' => $request->desc,
            'reason' => $request->reason,
            'userID' => $request->userID,
            'cost' => $request->cost,
        ]);
        return redirect()->route('incoming.index')->with('msg', 'added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Incoming::where('incomingID', $id)->first();
        $username = User::where('userID', $data['userID'])->first()['name'];
        return view("incoming.show",['username' => $username, 'data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function edit(Incoming $incoming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incoming $incoming)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        $incoming = Incoming::where('incomingID', $id);
        $incoming->delete();
        return redirect()->route('incoming.index')->with('msg', 'deleted successfully');
    }
}
