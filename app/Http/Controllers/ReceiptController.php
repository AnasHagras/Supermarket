<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\ProductReceiptCompany;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Receipt::all();
        return view('receipt.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('receipt.create');
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
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Receipt::where('receiptID', $id)->first();
        $products = ProductReceiptCompany::where('receiptID',$id)->get();
        $companyID = ProductReceiptCompany::where('receiptID',$id)->first()['companyID'];
        $companyName = Company::where('companyID',$companyID)->first()['companyName'];
        $userID = Receipt::where('receiptID',$id)->first()['userID'];
        $username = User::where('userID',$userID)->first()['name'];
        return view('receipt.show', ['data' => $data,'products'=>$products
        ,'username'=>$username,'userID'=>$userID,'companyID'=>$companyID,'companyName'=>$companyName]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receipt = Receipt::where('receiptID', $id);
        $receipt->delete();
        return redirect()->route('receipt.index')->with('msg', 'deleted successfully');
    }
}
