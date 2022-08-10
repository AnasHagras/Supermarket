<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\User;
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
            if ($employees->count() == 0) {
                return response()->json(['status' => 201, 'msg' => 'no matching records']);
            }
            $employees = json_encode($employees);
            return response()->json(['status' => 200, 'employees' => $employees]);
        } else if ($request['type'] == '7') {
            $searchText = $request['searchText'];
            $products = Product::where('productName', 'like', '%' . $searchText . '%')->get();
            if ($products->count() == 0) {
                return response()->json(['status' => 201, 'msg' => 'no matching records']);
            }
            $products = json_encode($products);
            return response()->json(['status' => 200, 'products' => $products]);
        } else if ($request['type'] == '8') {
            $searchText = $request['searchText'];
            $invoices = Invoice::where('invoiceID', $searchText)->get();
            if ($invoices->count() == 0) {
                return response()->json(['status' => 201, 'msg' => 'no matching records']);
            }
            $invoices = json_encode($invoices);
            return response()->json(['status' => 200, 'invoices' => $invoices]);
        } else if ($request['type'] == '9') {
            $searchText = $request['searchText'];
            $catagories = Catagory::where('catagoryName', 'like', '%' . $searchText . '%')->get();
            if ($catagories->count() == 0) {
                return response()->json(['status' => 201, 'msg' => 'no matching records']);
            }
            $catagories = json_encode($catagories);
            return response()->json(['status' => 200, 'catagories' => $catagories]);
        } else if ($request['type'] == '10') {
            $searchText = $request['searchText'];
            $users = User::where('username', 'like', '%' . $searchText . '%')->get();
            if ($users->count() == 0) {
                return response()->json(['status' => 201, 'msg' => 'no matching records']);
            }
            $users = json_encode($users);
            return response()->json(['status' => 200, 'users' => $users]);
        } else if ($request['type'] == '11') {
            $searchText = $request['searchText'];
            $receipts = Receipt::where('receiptID', $searchText)->get();
            if ($receipts->count() == 0) {
                return response()->json(['status' => 201, 'msg' => 'no matching records']);
            }
            $receipts = json_encode($receipts);
            return response()->json(['status' => 200, 'receipts' => $receipts]);
        }else if($request['type']=='12'){
            $searchText = $request['searchText'];
            $companies = Company::where('companyName', 'like', '%' . $searchText . '%')->get();
            if ($companies->count() == 0) {
                return response()->json(['status' => 201, 'msg' => 'no matching records']);
            }
            $companies = json_encode($companies);
            return response()->json(['status' => 200, 'companies' => $companies]);
        }
    }
}
