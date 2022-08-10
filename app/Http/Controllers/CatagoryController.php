<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatagoryRequest;
use App\Models\Catagory;
use App\Models\Product;
use Illuminate\Http\Request;

class CatagoryController extends Controller
{
    public function __construct()
    {
        // Middleware only applied to these methods
        $this->middleware('access', [
            'only' => [
                'update',
                'store',
                'edit',
                'destroy'
            ]
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Catagory::all();
        return view('catagory.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catagory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatagoryRequest $request)
    {
        $validator = $request->validated();
        if (!empty($validator->errors)) {
            return back()->withErrors($validator)->withInput();
        }
        Catagory::create([
            'catagoryName' => $request->catagoryName,
        ]);

        return redirect()->route('catagory.index')->with('msg', 'added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catagory  $catagory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Catagory::where('catagoryID', $id)->first();
        $products = Product::where('catagoryID', $id)->get(['barcode', 'productName']);
        return view('catagory.show', ['data' => $data, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catagory  $catagory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Catagory::where('catagoryID', $id)->first();
        return view('catagory.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catagory  $catagory
     * @return \Illuminate\Http\Response
     */
    public function update(CatagoryRequest $request, $id)
    {
        $validator = $request->validated();
        if (!empty($validator->errors)) {
            return back()->withErrors($validator)->withInput();
        }
        $catagory = Catagory::where('catagoryID', $id)->first();
        $catagory->update([
            'catagoryName' => $request->catagoryName,
        ]);
        return redirect()->route('catagory.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catagory  $catagory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $catagory = Catagory::where('catagoryID', $id);
        $catagory->delete();
        return redirect()->route('catagory.index')->with('msg', 'deleted successfully');
    }
}
