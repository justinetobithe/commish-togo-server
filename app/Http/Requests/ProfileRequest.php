<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'user_id'        => 'required|exists:users,id',
            'brief_description'         => 'nullable|string|max:255',
            'bio'            => 'nullable|string',
            'skills'         => 'nullable|string|max:255',
            'portfolio_url'  => 'nullable|url|max:255',
            'hourly_rate'    => 'nullable|string|max:255',
            'availability'   => 'nullable|string|max:255',
        ];
    }
}
