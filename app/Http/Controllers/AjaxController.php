<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getProduct(Request $request)
    {
        $barcode = $request['barcode'];
        $count = $request['count'];
        // check if any of them if null 
        if (!is_numeric($barcode) || !is_numeric($count))
            return response()->json(['status' => 201, 'msg' => "Barcode and count cannot be empty!"]);
        // check if barcode not exists 
        $product = Product::where('barcode', $request->barcode)->first();
        if (isset($product)) {
            $stock = $product['stock'];
            if($stock<$request['count']){
                return response()->json(['status' => 201, 'msg' => "Only $stock items is Available for $product->productName"]);
            }
            $product = json_encode($product);
            return response()->json(['status' => 200, 'product' => $product]);
        } else {
            return response()->json(['status' => 201, 'msg' => "Product not available , <a href = 'product/create'> Add Product</a>"]);
        }
        // check if count is not available
        // every thing is ok return product 


    }
}
