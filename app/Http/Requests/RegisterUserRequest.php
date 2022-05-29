<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|alpha_dash|min:3|max:191|unique:users',
            'email' => 'required|max:191|unique:users',
            'password' => 'confirmed',
            // 'agree' => 'required',
            'dob' => 'required',
            'profile_image' => 'image',
            'origin_country_name' => 'required|string',
            'residence_country_name' => 'required|string',
            'origin_latitude' => 'required',
            'origin_longitude' => 'required',
            'residence_latitude' => 'required',
            'residence_longitude' => 'required',
            'gender' => 'required',
            'nickname' => 'required',

        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->messages()->first(),
            'field' => $validator->errors()->keys()[0]
        ]));
    }
}
