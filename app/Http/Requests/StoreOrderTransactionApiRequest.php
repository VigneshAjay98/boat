<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreOrderTransactionApiRequest extends FormRequest
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
            'order_date'    => 'required',
            'status'     =>  'nullable',
            'order_id'     =>  'nullable',
            'user_id'     =>  'nullable',
            'payment_type' => 'required',
            'transaction_id' => 'required|unique:order_transactions,transaction_id,' . \Request('uuid') . ',uuid',
            'stripe_customer_id' => 'required',
            'stripe_payment_id' => 'required',
            'order_total'       => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        //to get validation error use $validator->errors()
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'error' => $validator->errors()
        ], 422));
    }
}
