<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getProduct(Request $request)
    {
        // return  $request->barcode;
        // die();
        $product = Product::where('barcode', $request->barcode)->first();
        $product = json_encode($product);
        return response($product);
    }
}
