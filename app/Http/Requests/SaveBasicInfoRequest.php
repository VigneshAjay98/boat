<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveBasicInfoRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'boat_type'    => 'required',
            'category'    => 'required',
            'boat_condition'     =>  'required',
            'year'    => 'required',
            'brand'     =>  'required',
            'brand_model'     =>  'required',
            'length'     =>  'required|numeric|min:10',
            'beam'     =>  'nullable||numeric|min:10',
            'draft'     =>  'required|numeric|min:2',
            'bridge_clearance'     =>  'nullable|numeric|min:2',
            'price'    => 'required',
            'price_currency'    => 'required',
            'boat_uuid'     =>  'nullable'
        ];
    }
}
