<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterCommentRequest extends FormRequest
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
            'role' => 'required|string|max:255',
            'type_work' => 'required|string|max:255',
            'name_client' => 'required|string|max:255',
            'phone_client' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'recommendations' => 'required|string|max:255',
            'emotion_rating' => 'required|integer|between:1,5',
            'payment_rating' => 'required|integer|between:1,5',
            'quality_rating' => 'required|integer|between:1,5',
            'delivery_rating' => 'required|integer|between:1,5',
            'honesty_rating' => 'required|integer|between:1,5',
            'post_id' => 'required|integer|exists:posts,id',
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'Поле "Роль" обязательно для заполнения',
            'role.string' => 'Поле "Роль" должно быть строкой',
            'role.max' => 'Поле "Роль" не должно превышать 255 символов',
            'type_work.required' => 'Поле "Тип работы" обязательно для заполнения',
            'type_work.string' => 'Поле "Тип работы" должно быть строкой',
            'type_work.max' => 'Поле "Тип работы" не должно превышать 255 символов',
            'name_client.required' => 'Поле "Имя клиента" обязательно для заполнения',
            'name_client.string' => 'Поле "Имя клиента" должно быть строкой',
            'name_client.max' => 'Поле "Имя клиента" не должно превышать 255 символов',
            'phone_client.required' => 'Поле "Телефон клиента" обязательно для заполнения',
            'phone_client.string' => 'Поле "Телефон клиента" должно быть строкой',
            'phone_client.max' => 'Поле "Телефон клиента" не должно превышать 255 символов',
            'experience.required' => 'Поле "Опыт работы" обязательно для заполнения',
            'experience.string' => 'Поле "Опыт работы" должно быть строкой',
            'experience.max' => 'Поле "Опыт работы" не должно превышать 255 символов',
            'recommendations.required' => 'Поле "Рекомендации" обязательно для заполнения',
            'recommendations.string' => 'Поле "Рекомендации" должно быть строкой',
            'recommendations.max' => 'Поле "Рекомендации" не должно превышать 255 символов',
            'emotion_rating.required' => 'Поле "Оценка эмоции" обязательно для заполнения',
            'emotion_rating.integer' => 'Поле "Оценка эмоции" должно быть числом',
            'emotion_rating.between' => 'Поле "Оценка эмоции" должно быть в диапазоне от 1 до 5',
            'payment_rating.required' => 'Поле "Оценка оплаты" обязательно для заполнения',
            'payment_rating.integer' => 'Поле "Оценка оплаты" должно быть числом',
            'payment_rating.between' => 'Поле "Оценка оплаты" должно быть в диапазоне от 1 до 5',
            'quality_rating.required' => 'Поле "Оценка качества" обязательно для заполнения',
            'quality_rating.integer' => 'Поле "Оценка качества" должно быть числом',
            'quality_rating.between' => 'Поле "Оценка качества" должно быть в диапазоне от 1 до 5',
            'delivery_rating.required' => 'Поле "Оценка доставки" обязательно для заполнения',
            'delivery_rating.integer' => 'Поле "Оценка доставки" должно быть числом',
            'delivery_rating.between' => 'Поле "Оценка доставки" должно быть в диапазоне от 1 до 5',
            'honesty_rating.required' => 'Поле "Оценка честности" обязательно для заполнения',
            'honesty_rating.integer' => 'Поле "Оценка честности" должно быть числом',
            'honesty_rating.between' => 'Поле "Оценка честности" должно быть в диапазоне от 1 до 5',
            'post_id.required' => 'Поле "Пост" обязательно для заполнения',
            'post_id.integer' => 'Поле "Пост" должно быть числом',
            'post_id.exists' => 'Поле "Пост" не существует в базе данных'
        ];
    }
}
