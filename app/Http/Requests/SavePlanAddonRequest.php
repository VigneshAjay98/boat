<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\PlanAddon;
use Illuminate\Validation\ValidationException;

class SavePlanAddonRequest extends FormRequest
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
            'plan_id' => 'required',
            'addon_cost' => 'required',
		];

        if($this->has('uuid') && !empty($this->uuid)){
            $rules['addon_name']  = 'required | max:255' . \Request('uuid') . ',uuid';
        } else{
            $rules['addon_name']  = 'required | max:255';
        }

		return $rules;
	}


    protected function prepareForValidation()
    {
        $plan_id = $this->plan_id;
        $addon_name = $this->addon_name;
        if ($this->has('plan_id') && $this->has('addon_name'))
        {
            $names = \App\Models\PlanAddon::select('addon_name')
            ->where('plan_id', $plan_id)
            ->pluck('addon_name')
            ->toArray();
            if (in_array($addon_name, $names)){
                throw ValidationException::withMessages(['addon_name' => 'Addon name should be unique.']);
            }
        }
    }
}
