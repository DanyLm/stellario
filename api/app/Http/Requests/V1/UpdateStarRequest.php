<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStarRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'min:3', 'max:30'],
            'last_name' => ['required', 'min:3', 'max:30'],
            'description' => ['required'],
            'popularity' => ['required', 'integer', 'between:1,99'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'Le prénom est requis.',
            'last_name.required' => 'Le nom est requis',
            'description.required' => 'La description est requies.',
            'popularity.required' => 'Le taux de popularité est requis.',
            'popularity.between' => 'Le taux de popularité doit être entre 1 et 99%.'
        ];
    }
}
