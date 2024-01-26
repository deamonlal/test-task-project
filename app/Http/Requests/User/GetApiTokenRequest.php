<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class GetApiTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'lowercase', 'email', 'max:255'],
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'This field must be filled in',
            'email.email' => 'This field should be a email type',
            'password.required' => 'This field must be filled in',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ]));
    }

    public function authenticate($data): bool|JsonResponse
    {
        if (!auth()->attempt($data)) {
            return response()->json([
                'message' => 'The given data was invalid',
                'errors' => [
                    'email|password' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }
        return true;
    }
}
