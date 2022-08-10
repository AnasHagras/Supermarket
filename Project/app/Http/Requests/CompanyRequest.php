<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $id = request()->route('company');
        return [
            'companyName' => 'required|unique:companies,companyName,' . $id . ',companyID' . '|regex:/^[a-zA-Z]+$/u',
            'companyEmail' => 'required|unique:companies,companyEmail,' . $id . ',companyID' . '|email:filter'
        ];
    }
}
