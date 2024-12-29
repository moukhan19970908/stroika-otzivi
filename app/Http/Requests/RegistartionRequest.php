<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistartionRequest extends FormRequest
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
            'fio' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|min:11|max:11',
            'user_type_id' => 'required|exists:user_types,id',
            'password' => 'required|string|min:8',
            'experience' => [
                'required_if:user_type_id,1',
                'required_if:user_type_id,2',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'fio.required' => 'ФИО обязательно для заполнения',
            'fio.string' => 'ФИО должно быть текстовым',
            'fio.max' => 'ФИО не может превышать 255 символов',
            'email.required' => 'E-mail обязатен для заполнения',
            'email.string' => 'E-mail должен быть текстовым',
            'email.email' => 'E-mail должен быть валидным',
            'email.max' => 'E-mail не может превышать 255 символов',
            'email.unique' => 'Этот E-mail уже зарегистрирован',
            'password.required' => 'Пароль обязатен для заполнения',
            'password.string' => 'Пароль должен быть текстовым',
            'password.min' => 'Пароль должен быть не менее 8 символов',
            'phone.string' => 'Телефон должен быть текстовым',
            'phone.min' => 'Телефон не может превышать 11 символов',
            'phone.max' => 'Телефон не может превышать 11 символов',
            'phone.required' => 'Телефон обязтель для заполнения',
            'phone.unique' => 'Этот телефон уже используется',
            'user_type_id.required' => 'Тип пользователя обязатен для заполнения',
            'user_type_id.exists' => 'Тип пользователя не существует',
            'user_type_id.required_if' => 'Опыт работы обязателен для зарегистрированных пользователей',
            'experience.required_if' => 'Опыт работы обязателен для зарегистрированных пользователей',
        ];
    }
}
