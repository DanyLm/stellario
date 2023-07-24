<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaceStarRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes::jpeg,png,jpg,gif', 'max:2048'],
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
            'image.required' => 'Une image est requise.',
            'image.max' => 'L\'image est trop volumineuse',
            'image.mimes' => 'Le type de l\'image doit être le suivant: jpeg,png,jpg,gif',
            'image.image' => 'Le type de l\'image doit être le suivant: jpeg,png,jpg,gif'
        ];
    }
}
