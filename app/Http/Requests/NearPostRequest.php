<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $latitude
 * @property string $longitude
 */
class NearPostRequest extends FormRequest
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
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required' => 'Поле latitude обязательно для заполнения.',
            'longitude.required' => 'Поле longitude обязательно для заполнения.',
        ];
    }
}
