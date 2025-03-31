<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationalAttainmentRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'institution_name' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date|before_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'is_current' => 'boolean',
        ];
    }
}
