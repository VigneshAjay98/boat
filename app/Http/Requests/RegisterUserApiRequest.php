<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterUserApiRequest extends FormRequest
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
     * if api not working then add remove App\Exceptions\Handler files response ajax option
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'    => 'required|max:255',
            'last_name'     =>  'nullable|max:255',
            'contact_number' => 'nullable|min:10|unique:users,contact_number,' . \Request('uuid') . ',uuid',
            'email'         => 'required|unique:users,email,' . \Request('uuid') . ',uuid',
            'password'      => 'required',
            'address'       => 'nullable',
            'city'          => 'nullable',
            'country'          => 'nullable',
            'state'         => 'nullable',
            'zip_code'      => 'nullable'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        //to get validation error use $validator->errors()
        throw new HttpResponseException(response()->json([
            'status'   => 'error'
        ], 422));
    }
}
