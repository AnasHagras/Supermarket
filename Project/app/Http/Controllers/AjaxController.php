<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class AjaxController extends Controller
{


    public function getProduct(Request $request)
    {
        // if request is to get Data 
        if ($request['type'] == '0' || $request['type'] == '3') {
            $barcode = $request['barcode'];
            $count = $request['count'];
            // check if any of them if null 
            if (!is_numeric($barcode) || !is_numeric($count))
                return response()->json(['status' => 201, 'msg' => "Barcode and count cannot be empty!"]);
            // check if barcode not exists 
            $product = Product::where('barcode', $request->barcode)->first();
            if (isset($product)) {
                if ($request['type'] == '3') return response()->json(['status' => 200, 'product' => json_encode($product)]);
                $stock = $product['stock'];
                if ($stock < $request['count']) {
                    return response()->json(['status' => 201, 'msg' => "Only $stock items is Available for $product->productName <a target='_blank' href = 'product/$product->barcode/edit'> Edit Product</a>"]);
                }
                return response()->json(['status' => 200, 'product' => json_encode($product)]);
            } else {
                return response()->json(['status' => 201, 'msg' => "Product not available <a href = 'product/create' target='_blank'> Add Product</a>"]);
            }
            // request is so save session 
        } else if ($request['type'] == '1') {
            session(['invoiceItems' => $request['toBeSaved']]);
            // return response()->json(['status' => 200, 'msg' => "successfully saved"]);
            // request is to delete session 
        } else if ($request['type'] == '2') {
            session()->forget("invoiceItems");
            // get data for receipt
        } else if ($request['type'] == '4') {
            session(['receiptItems' => $request['toBeSaved']]);
            // return response()->json(['status' => 200, 'msg' => "successfully saved"]);
            // delete receipt session
        } else if ($request['type'] == '5') {
            session()->forget("receiptItems");
            // get search data for employess
        } else if ($request['type'] == '6') {
            $searchText = $request['searchText'];
            $employees = Employee::where('firstName', 'like', '%' . $searchText . '%')
                ->orWhere('lastName', 'like', '%' . $searchText . '%')->get();
            if ($employees->count()==0) {
                return response()->json(['status' => 201, 'msg' => 'no matching records']);
            }
            $employees = json_encode($employees);
            return response()->json(['status' => 200, 'employees' => $employees]);
        }
    }
}
