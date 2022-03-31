<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Http\Repositories\UserRepository;

class SaveUserRequest extends FormRequest
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
            'first_name'    => 'required|max:255',
            'last_name'     =>  'required|max:255',
            'contact_number' => 'required',
            'email'         => 'required|unique:users,email,' . \Request('uuid') . ',uuid',
            'password'      => 'required_with:password_confirmation|required_without:uuid|same:password_confirmation',
            'password_confirmation' => 'required_without:uuid',
            'address'       => 'required',
            'city'          => 'required',
            'country'          => 'required',
            'state'         => 'required',
            'zip_code'      => 'required'
        ];
    }
}
