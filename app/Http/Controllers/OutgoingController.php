<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomingRequest;
use App\Models\Outgoing;
use App\Models\User;
use Illuminate\Http\Request;

class OutgoingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Outgoing::orderBy('date','DESC')->get();
        return view("outgoing.index", ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('outgoing.create', ['users' => $users]);
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
        Outgoing::create([
            'desc' => $request->desc,
            'reason' => $request->reason,
            'userID' => $request->userID,
            'cost' => $request->cost,
        ]);
        return redirect()->route('outgoing.index')->with('msg', 'added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outgoing  $outgoing
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Outgoing::where('outgoingID', $id)->first();
        $username = User::where('userID', $data['userID'])->first()['name'];
        return view("outgoing.show", ['username' => $username, 'data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outgoing  $outgoing
     * @return \Illuminate\Http\Response
     */
    public function edit(Outgoing $outgoing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outgoing  $outgoing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outgoing $outgoing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outgoing  $outgoing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $incoming = Outgoing::where('outgoingID', $id);
        $incoming->delete();
        return redirect()->route('outgoing.index')->with('msg', 'deleted successfully');
    }
}
