<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "address_name"=>"required",
            "first_name"=>"required",
            "last_name"=>"required",
            "email"=>"required",
            "phone"=>"required",
            "lat"=>"required",
            "lng"=>"required",
            "address1"=>"required",
            "address2"=>"required",
            "city"=>"required",
            "state_id"=>"required",
            "zipCode"=>"required",
            "is_primary"=>"required",
        ];
    }
}
