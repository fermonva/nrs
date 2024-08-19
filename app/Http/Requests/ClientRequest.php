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
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'dni' => [
                'required',
                'string',
                'max:255',
                // Rule::unique('clients', 'dni')->ignore($this->client->id)
            ],
            'registration_date' => ['required', 'date'],
            'provider_id' => ['required', 'integer', 'exists:providers,id'],
            'gas_quality_id' => ['required', 'integer', 'exists:gas_qualities,id'],
        ];

        if ($this->isMethod('post')) {
            $rules['dni'][] = Rule::unique('clients', 'dni');
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['dni'][] = Rule::unique('clients', 'dni')->ignore($this->client->id);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The :attribute field is required.',
            'last_name.required' => 'The :attribute field is required.',
            'dni.required' => 'The :attribute field is required.',
            'registration_date.required' => 'The :attribute field is required.',
            'provider_id.required' => 'The :attribute field is required.',
            'provider_id.exists' => 'The selected provider does not exist.',
            'gas_quality_id.required' => 'The :attribute field is required.',
            'gas_quality_id.exists' => 'The selected gas quality does not exist.',
        ];
    }
}
