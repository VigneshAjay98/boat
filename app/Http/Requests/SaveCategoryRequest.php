<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Http\Repositories\CategoryRepository;

class SaveCategoryRequest extends FormRequest
{
    private $categoryRepository;
    
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
            'description'    => 'required',
            'boat_type'     =>  'required',
            'activity'     =>  'required',
            'other_information'    => 'required',
        ];
    }
}
