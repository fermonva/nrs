<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProviderRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'cif' => ['required', 'string', 'max:255'],
            'registration_date' => ['required', 'date'],
        ];
        if ($this->isMethod('post')) {
            $rules['cif'][] = Rule::unique('providers', 'cif');
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['cif'][] = Rule::unique('providers', 'cif')->ignore($this->provider->id);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'The :attribute field is required.',
            'country.required' => 'The :attribute field is required.',
            'cif.required' => 'The :attribute field is required.',
            'registration_date.required' => 'The :attribute field is required.',
        ];
    }
}
