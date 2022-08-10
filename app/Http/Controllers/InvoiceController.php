<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Incoming;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Invoice::orderBy('invoiceDate', 'DESC')->get();
        // $data = Invoice::all();
        return view('invoice.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("cashier.index");
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
        if ($itemCount == 0) {
            return response()->json(['msg' => "Empty Invoice", 'status' => 201]);
        }
        // check stock for each item if one of item stock is less than item count return with message 
        foreach($products as $product){
            $currentProduct = Product::where('barcode',$product['barcode'])->first();
            if(null===$currentProduct)
                return response()->json(['msg' =>"Product $product->productName not available <a href = 'product/create' target='_blank'> Add Product</a>", 'status' => 201]);
            $currentStock = $currentProduct['stock'];
            if($currentStock < $product['count']){
                $name = $product['productName'];
                $barcode = $product['barcode'];
                return response()->json(['msg' =>"Only $currentStock items is Available for $name <a href = 'product/$barcode/edit' target='_blank'> Edit Product</a>", 'status' => 201]);
            }
        }
        $invoiceID = Invoice::create([
            'invoicePrice' => $totalPrice,
            'itemCounter' => $itemCount,
            'userID' => Auth::user()->userID
        ])->invoiceID;
        foreach ($products as $product) {
            InvoiceProduct::create([
                'itemTotalPrice' => $product['itemTotalPrice'],
                'itemCounter' => $product['count'],
                'invoiceID' => $invoiceID,
                'barcode' => $product['barcode'],
                'sellingPrice' => $product['sellingPrice']
            ]);
            $currentProduct = Product::where('barcode', $product['barcode'])->first();
            $currentProduct->update([
                'stock' => $currentProduct['stock'] - $product['count']
            ]);
        }
        Incoming::create([
            'desc' => "invoice income",
            'reason' => "Order",
            'cost' => $totalPrice,
            'userID' => Auth::user()->userID,
            'invoiceID' => $invoiceID
        ]);
        // return redirect()->route("cashier.index")->with('msg','added successfully');
        return response()->json(['msg' => "added successfully", 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Invoice::where('invoiceID', $id)->first();
        $productInovice = InvoiceProduct::where('invoiceID', $id)->get();
        $products = [];
        foreach ($productInovice as $product) {
            $item = Product::where("barcode", $product['barcode'])->first();
            $item['itemCounter'] = $product['itemCounter'];
            $item['itemTotalPrice'] = $product['itemTotalPrice'];
            $products[] = $item;
        }
        $userID = invoice::where('invoiceID', $id)->first()['userID'];
        $username = User::where('userID', $userID)->first()['name'];
        return view('invoice.show', [
            'data' => $data, 'products' => $products, 'username' => $username, 'userID' => $userID
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::where('invoiceID', $id);
        $invoice->delete();
        return redirect()->route('invoice.index')->with('msg', 'deleted successfully');
    }
}
