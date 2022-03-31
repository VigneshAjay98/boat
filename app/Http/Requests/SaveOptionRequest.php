<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Http\Repositories\OptionRepository;

class SaveOptionRequest extends FormRequest
{
    private $optionRepository;
    
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }
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
            'name'    => 'required',
            'option_type'     =>  'required',
        ];
    }
}
