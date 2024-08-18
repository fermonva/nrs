<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'dni' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clients', 'dni')->ignore($this->client->id)
            ],
            'registration_date' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The :attribute field is required.',
            'last_name.required' => 'The :attribute field is required.',
            'dni.required' => 'The :attribute field is required.',
            'registration_date.required' => 'The :attribute field is required.',
        ];
    }
}
