<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogAddCommentRequest extends FormRequest
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
            'text' => 'required|string',
            'blog_id' => 'required|integer|exists:blogs,id',
        ];
    }

    public function messages(): array
    {
        return [
            'text.required' => 'Текст должен быть заполнен',
            'blog_id.required' => 'Айди блога должен быть заполнен',
            'blog_id.integer' => 'Айди блога должен быть числом',
            'blog_id.exists' => 'Блог с указанным идентификатором не найден',
        ];
    }
}
