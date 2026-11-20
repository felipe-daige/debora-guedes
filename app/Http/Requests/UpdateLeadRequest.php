<?php

namespace App\Http\Requests;

use App\LeadStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
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
        return [
            'status' => ['required', Rule::enum(LeadStatus::class)],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'next_contact_at' => ['nullable', 'date'],
            'potential_value' => ['nullable', 'numeric', 'min:0'],
            'lost_reason' => ['nullable', 'required_if:status,lost', 'string', 'max:2000'],
            'note' => ['nullable', 'string', 'max:3000'],
        ];
    }
}
