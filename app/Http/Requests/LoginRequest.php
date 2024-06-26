<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class LoginRequest extends FormRequest {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "email" => "required",
            "password" => "required",
        ];
    }

    public function failedValidation(Validator $validator) {
        $key = array_keys($validator->errors()->getMessages())[0];

        $response = response()->json([
            "success" => false,
            "data" => null,
            "errorCode" => $key . '_required',
        ], Response::HTTP_BAD_REQUEST);

        throw new HttpResponseException($response);
    }
}
