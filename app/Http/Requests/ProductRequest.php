<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = request()->route('product');
        return [
            'barcode' => 'required|unique:products,barcode,' . $id . ',barcode|numeric',
            'productName' => 'required|unique:products,productName,' . $id . ',barcode',
            'sellingPrice' => 'required|numeric',
            'purcashingPrice' => 'required|numeric',
            'companyID' => 'required',
            'catagoryID' => 'required'
        ];
    }
}
