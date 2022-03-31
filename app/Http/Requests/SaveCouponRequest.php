<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCouponRequest extends FormRequest
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
            'type'  =>  'required',
            'expiry_date' => 'nullable',
		];

        if($this->has('id') && !empty($this->id)){
            $rules['code']  = 'required | max:255 | unique:coupons,code,' . \Request('id') . ',id';
            // $rules['stripe_coupon_id'] = 'nullable | unique:coupons,stripe_coupon_id,' . \Request('id') . ',id';
        } else{
            $rules['code']  = 'required | max:255 | unique:coupons,code';
            // $rules['stripe_coupon_id'] = 'nullable | unique:coupons,stripe_coupon_id';
        }

		if ($this->has('type') && !empty($this->type) && $this->type == 'percentage') {;
			$rules['amount'] = 'required | numeric | min:0 | max:100';
		}elseif ($this->has('type') && !empty($this->type) && $this->type == 'fixed') {
			$rules['amount'] = 'required | numeric';
		}else{
            $rules['amount'] = 'nullable | numeric';
		}

		return $rules;
	}
}
