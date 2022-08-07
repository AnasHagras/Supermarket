<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Catagory;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();

        return view('product.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catagories = Catagory::all();
        $companies = Company::all();
        return view('product.create', ['catagories' => $catagories, 'companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        $validator = $request->validated();

        if (!empty($validator->errors)) {
            return back()->withErrors($validator->errors)->withInput();
        }


        Product::create([
            'barcode' => $request->barcode,
            'productName' => $request->productName,
            'sellingPrice' => $request->sellingPrice,
            'purcashingPrice' => $request->purcashingPrice,
            'stock' => $request->stock,
            'catagoryID' => $request->catagoryID,
            'companyID' => $request->companyID
        ]);

        return redirect()->route('product.index')->with('msg', 'added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $data = Product::findOrFail($id); // select * from departments where id=$id limit 1
        $data = Product::where('barcode', $id)->first(); // select * from departments where dept_id=$id limit 1 => fetch => no need to foreach
        //$data = Department::where('dept_name', $id)->get(); // select * from departments where dept_name=$id => fetchAll =>foreach
        $data['catagoryName'] = Catagory::where('catagoryID', $data['catagoryID'])->first()['catagoryName'];
        $data['companyName'] = Company::where('companyID', $data['companyID'])->first()['companyName'];
        return view('product.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::where('barcode', $id)->first();
        $companies = Company::all();
        $catagories = Catagory::all();
        return view('product.edit', ['data' => $data, 'companies' => $companies, 'catagories' => $catagories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $validator = $request->validated();

        if (!empty($validator->errors)) {
            return back()->withErrors($validator->errors)->withInput();
        }

        $product = Product::where('barcode', $id)->first();
        $product->update([
            'barcode' => $request->barcode,
            'productName' => $request->productName,
            'sellingPrice' => $request->sellingPrice,
            'purcashingPrice' => $request->purcashingPrice,
            'stock' => $request->stock,
            'catagoryID' => $request->catagoryID,
            'companyID' => $request->companyID
        ]);
        return Redirect::to($request->url())->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('barcode', $id)->first();
        $product->delete();
        return redirect()->route('product.index')->with('msg', 'deleted successfully');
    }
}
