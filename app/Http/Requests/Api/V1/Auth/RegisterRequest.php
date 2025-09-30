<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Solid\Traits\JsonTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    use JsonTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:25',
            ],
            'email' => [
                'required',
                'email',
                'unique:users',
            ],
            'password' => [
                'required',
                'min:6',
                'max:25',
            ],
            'password_confirm' => [
                'required',
                'same:password'
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $err = $validator->errors()->first();
        throw new HttpResponseException($this->whenError($err));
    }
}
