<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' => 'required|string|min:8|max:50',
            'new_password' => 'required|string|min:8|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Пожалуйста, введите текущий пароль',
            'current_password.min' => 'Пароль должен быть минимум 8 символов',
            'current_password.max' => 'Пароль должен быть не более 50 символов',
            'new_password.required' => 'Пожалуйста, введите новый пароль',
            'new_password.min' => 'Пароль должен быть минимум 8 символов',
            'new_password.max' => 'Пароль должен быть не более 50 символов',
        ];
    }
}
