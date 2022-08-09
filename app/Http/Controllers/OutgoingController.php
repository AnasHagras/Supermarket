<?php

namespace App\Http\Controllers;

use App\Models\Outgoing;
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
        $data = Outgoing::all();
        return view("incoming.index",['data'=>$data]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outgoing  $outgoing
     * @return \Illuminate\Http\Response
     */
    public function show(Outgoing $outgoing)
    {
        //
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
    public function destroy(Outgoing $outgoing)
    {
        //
    }
}
