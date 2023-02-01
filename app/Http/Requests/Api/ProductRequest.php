<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "type_id" => "required",
            "category_id" => "required",
            "name" => "required",
            "short_description" => "required",
            "description" => "required",
            "rule_for_use" => "required",
            "privacy_notes" => "required",
            "price1" => "required",
            "cover"=>"required",
            "minimum_rent_days" => "required",
            "value" => "required",
            "media_files" => "required",
            "available_slots" => "required",
            "lat" => "required",
            "lng" => "required",
            "address1"=>"required",
            "address2"=>"required",
            "city"=>"required",
            "state_id"=>"required",
            "zipcode"=>"required",
        ];
    }
}
