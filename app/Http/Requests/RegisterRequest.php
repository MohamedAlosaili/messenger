<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class RegisterRequest extends FormRequest {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => "required|max:256",
            "email" => "required|email|max:256",
            "password" => "required|min:6|max:256",
        ];
    }

    public function failedValidation(Validator $validator) {
        $msg = $validator->errors()->first();
        $key = array_keys($validator->errors()->getMessages())[0];
        $prefix = !str_contains($msg, "required") ? "invalid_" : "";
        $suffix = str_contains($msg,"required") ? "_required" : "";

        $response = response()->json([
            "success" => false,
            "errorCode" => $prefix . $key . $suffix,
        ], Response::HTTP_BAD_REQUEST);

        throw new HttpResponseException($response);
    }
}
