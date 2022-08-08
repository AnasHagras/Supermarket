<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatagoryRequest extends FormRequest
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
        $id = request()->route('catagory');
        return [
            'catagoryName' => 'required|unique:catagories,catagoryName,' . $id . ',catagoryID' . '|regex:/^[a-zA-Z]+$/u',
        ];
    }
}
