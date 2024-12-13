<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $code
 * @property string $phone
 */
class VerificationRequest extends FormRequest
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
            'phone' => 'required|string',
            'code' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Поле телефон обязательно для заполнения',
            'phone.string' => 'Поле телефон должно быть строкой',
            'code.required' => 'Поле кода подтверждения обязательно для заполнения',
        ];
    }
}
