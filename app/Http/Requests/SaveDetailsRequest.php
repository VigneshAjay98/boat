<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDetailsRequest extends FormRequest
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
            'engine_type1' => 'required',
            'fuel_type1' => 'required',
            'make1' => 'required',
            'model1' => 'required',
            'horse_power1' => 'required',
            'engine_hours1' => 'required',
            'hull_material' =>  'required',
            'hull_id' =>  'string|min:12|max:12|nullable',
            'anchor_check' => 'sometimes',
            'anchor_type' => 'required_if:hull_id,on',
            'fuel_capacity' => 'required',
            'fresh_water' => 'nullable',
            'holding' => 'nullable',
            'cruising_speed' => 'nullable',
            'max_speed' => 'nullable',
            'loa' => 'nullable',
            'tanks' => 'nullable',
            'boat_name' => 'nullable',
            'designer' => 'nullable',
            'head' => 'nullable',
            'electrical_system' => 'nullable',
            'generator_check' => 'sometimes',
            'generator_fuel_type' => 'required_if:generator_check,on',
            'generator_size' => 'required_if:generator_check,on',
            'generator_hours' => 'required_if:generator_check,on',
            'cabin_check' => 'sometimes',
            'cabin_berths' => 'required_if:cabin_check,on',
            'cabin_description' => 'required_if:cabin_check,on',
            'galley_check' => 'sometimes',
            'galley_description' => 'required_if:galley_check,on',
            'boat_uuid' => 'nullable'
        ];
    }
}
