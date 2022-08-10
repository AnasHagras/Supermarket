<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = request()->route('user');
        return [
            'name' => 'required|regex:/^[a-zA-Z]+$/u',
            'username' => 'required|unique:users,username,' . $id . ',userID' . '|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/',
            'email' => 'required|unique:users,email,' . $id . ',userID' . '|email:filter',
            'password' => 'required|min:8',
            'isAdmin' => 'required',
        ];
    }
}
