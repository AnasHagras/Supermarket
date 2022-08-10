<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Outgoing;
use App\Models\Product;
use App\Models\ProductReceiptCompany;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

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
        $companies = Company::all();
        return view('receipt.create', ['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = $request['data'];
        $totalPrice = $request['totalPrice'];
        $itemCount = $request['itemCount'];
        $companyID = $request['companyID'];
        if($companyID==""){
            return response()->json(['msg' => "Select Company", 'status' => 201]);
        }
        if ($itemCount == 0) {
            return response()->json(['msg' => "Empty Invoice", 'status' => 201]);
        }
        // check existance for each product 
        foreach ($products as $product) {
            $currentProduct = Product::where('barcode',$product['barcode'])->first();
            if(null==$currentProduct)
                return response()->json(['msg' =>"Product $product[barcode] not available <a href = 'product/create' target='_blank'> Add Product</a>", 'status' => 201]);
            if($currentProduct['companyID']!=$companyID){
                return response()->json(['msg' =>"Product $product[productName] not owned by that company <a target='_blank' href = '/product/$product[barcode]/edit'> Edit Product</a>", 'status' => 201]);
            }
        }
        $receiptID = Receipt::create([
            'receiptPrice' => $totalPrice,
            'itemCounter' => $itemCount,
            'userID' => Auth::user()->userID,
            'companyID' => $companyID
        ])->receiptID;
        // return response()->json(['msg' => "$receiptID", 'status' => 201]);
        foreach ($products as $product) {
            ProductReceiptCompany::create([
                'itemTotalPrice' => $product['itemTotalPrice'],
                'itemCounter' => $product['count'],
                'receiptID' => $receiptID,
                'barcode' => $product['barcode'],
                'companyID' => $companyID
            ]);
            $currentProduct = Product::where('barcode', $product['barcode'])->first();
            $currentProduct->update([
                'stock' => $currentProduct['stock'] + $product['count']
            ]);
        }
        Outgoing::create([
            'desc' => "receipt outgoing",
            'reason' => "Purchase",
            'cost' => $totalPrice,
            'userID' => Auth::user()->userID,
            'receiptID' => $receiptID
        ]);
        return response()->json(['msg' => "added successfully", 'status' => 200]);
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
        $products = ProductReceiptCompany::where('receiptID', $id)->get();
        $companyID = ProductReceiptCompany::where('receiptID', $id)->first()['companyID'];
        $companyName = Company::where('companyID', $companyID)->first()['companyName'];
        $userID = Receipt::where('receiptID', $id)->first()['userID'];
        $username = User::where('userID', $userID)->first()['name'];
        return view('receipt.show', [
            'data' => $data, 'products' => $products, 'username' => $username, 'userID' => $userID, 'companyID' => $companyID, 'companyName' => $companyName
        ]);
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
