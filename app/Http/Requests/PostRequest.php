<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            // 'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',

            'service_id' => 'nullable|array',
            'service_id.*' => 'exists:services,id',

            'content' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string',
            'type' => 'required|in:contract,freelance,full-time,part-time',
            'application_deadline' => 'nullable|date',
        ];
    }
}
