<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePlanRequest extends FormRequest
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

		$rules = [
            'price' => 'required',
            'duration_weeks' => 'nullable',
            'image_number' => 'nullable',
            'video_number' => 'nullable',
		];

        if($this->has('uuid') && !empty($this->uuid)){
            $rules['name']  = 'required | max:255 | unique:plans,name,' . \Request('uuid') . ',uuid';
            // $rules['stripe_price_id'] = 'nullable | unique:plans,stripe_price_id,' . \Request('uuid') . ',uuid';
            // $rules['stripe_product_id'] = 'nullable | unique:plans,stripe_product_id,' . \Request('uuid') . ',uuid';

        }else{
            $rules['name']  = 'required | max:255 | unique:plans,name';
        }

		return $rules;
	}
}
