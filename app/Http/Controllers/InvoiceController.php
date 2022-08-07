<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
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
        $totalPrice = ($request['totalPrice']);
        $itemCount = $request['itemCount'];
        // return response()->json(['msg'=>$totalPrice]);
        $invoiceID = Invoice::create([
            'invoicePrice' => $totalPrice,
            'itemCounter' => $itemCount,
            'userID' => Auth::user()->userID
        ])->invoiceID;
        foreach($products as $product){ 
            InvoiceProduct::create([
                'itemTotalPrice' => $product['itemTotalPrice'],
                'itemCounter' => $product['count'],
                'invoiceID' => $invoiceID,
                'barcode' => $product['barcode']
            ]);
        }
        // return redirect()->route("cashier.index")->with('msg','added successfully');
        return response()->json(['msg'=>"added successfully",'status'=>200]);
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
        $products = InvoiceProduct::where('invoiceID',$id)->get();
        $userID = invoice::where('invoiceID',$id)->first()['userID'];
        $username = User::where('userID',$userID)->first()['name'];
        return view('invoice.show', ['data' => $data,'products'=>$products
        ,'username'=>$username,'userID'=>$userID]);
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
