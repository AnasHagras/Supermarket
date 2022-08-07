<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Employee;

class EmployeeRequest extends FormRequest
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
        $id = request()->route('employee');
        return [
            'firstName' => 'required|regex:/^[a-zA-Z]+$/u',
            'lastName' => 'required|regex:/^[a-zA-Z]+$/u',
            'phone' => 'required|digits:11|unique:employees,phone,' . $id . ',employeeID',
            'age' => 'required|numeric',
            'salary' => 'required|numeric',
            'gender' => 'required',
            'position' => 'required'
        ];
    }
}
