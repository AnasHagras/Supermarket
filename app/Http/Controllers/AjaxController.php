<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class AjaxController extends Controller
{


    public function getProduct(Request $request)
    {
        // if request is to get Data 
        if ($request['type'] == '0') {
            $barcode = $request['barcode'];
            $count = $request['count'];
            // check if any of them if null 
            if (!is_numeric($barcode) || !is_numeric($count))
                return response()->json(['status' => 201, 'msg' => "Barcode and count cannot be empty!"]);
            // check if barcode not exists 
            $product = Product::where('barcode', $request->barcode)->first();
            if (isset($product)) {
                $stock = $product['stock'];
                if ($stock < $request['count']) {
                    return response()->json(['status' => 201, 'msg' => "Only $stock items is Available for $product->productName <a href = 'product/$product->barcode/edit'> Edit Product</a>"]);
                }
                $product = json_encode($product);
                return response()->json(['status' => 200, 'product' => $product]);
            } else {
                return response()->json(['status' => 201, 'msg' => "Product not available , <a href = 'product/create'> Add Product</a>"]);
            }
        // request is so save session 
        } else if($request['type']=='1'){
            session(['invoiceItems' => $request['toBeSaved']]);
            return response()->json(['status' => 200, 'msg' => "successfully saved"]);
        // request is to delete session 
        }else {
            session()->forget("invoiceItems");
        }
    }
}
