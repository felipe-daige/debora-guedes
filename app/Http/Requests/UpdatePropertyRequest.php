<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdatePropertyRequest extends StorePropertyRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['reference'] = ['required', 'string', 'max:40', Rule::unique('properties')->ignore($this->route('property'))];
        $rules['slug'] = ['nullable', 'string', 'max:180', Rule::unique('properties')->ignore($this->route('property'))];

        return $rules;
    }
}
