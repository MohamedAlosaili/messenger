<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateRoomRequest extends FormRequest {


    public function rules()
    {
        return [
            "name" => "required|string|max:75"
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
