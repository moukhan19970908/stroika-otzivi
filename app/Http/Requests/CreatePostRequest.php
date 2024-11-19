<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required|string|max:255',
            'gallery' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Необходимо указать заголовок.',
            'title.string' => 'Заголовок должен быть строкой и не должен превышать 255 символов.',
            'title.max' => 'Заголовок не должен превышать 255 символов.',
            'description.required' => 'Описание должно быть заполнено.',
            'description.string' => 'Описание должно быть строкой.',
            'latitude.required' => 'Широта должна быть указана.',
            'longitude.required' => 'Долгота должна быть указана.',
            'address.required' => 'Адрес должен быть указан.',
            'address.string' => 'Адрес должен быть строкой и не должен превышать 255 символов.',
            'address.max' => 'Адрес не должен превышать 255 символов.',
            'gallery.required' => 'Изображения галереи должны быть указаны.',
            'gallery.array' => 'Изображения галереи должны быть массивом.',
        ];
    }
}
