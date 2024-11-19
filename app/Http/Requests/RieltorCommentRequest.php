<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RieltorCommentRequest extends FormRequest
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
            'advantage' => 'required|string',
            'disadvantage' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'post_id' => 'required|exists:posts,id',
            'gallery' => 'array'
        ];
    }

    public function messages(): array
    {
        return [
            'advantage.required' => 'Достоинство обязательно для заполнения',
            'disadvantage.required' => 'Недостаток обязательно для заполнения',
            'rating.required' => 'Рейтинг обязателен для заполнения',
            'rating.integer' => 'Рейтинг должен быть целым числом',
            'rating.between' => 'Рейтинг должен быть между 1 и 5',
            'post_id.required' => 'Запись обязательна для заполнения',
            'post_id.exists' => 'Запись с указанным идентификатором не найдена',
            'gallery.array' => 'Галерея должна быть массивом',
        ];
    }
}
