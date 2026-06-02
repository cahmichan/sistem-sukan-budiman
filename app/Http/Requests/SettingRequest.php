<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'registration_is_open' => ['nullable', 'boolean'],
            'registration_deadline' => ['nullable', 'date'],
            'event_date' => ['nullable', 'date'],
            'event_time' => ['nullable', 'string', 'max:50'],
            'event_venue' => ['nullable', 'string', 'max:255'],
            'admin_contact' => ['nullable', 'string', 'max:50'],
            'whatsapp_template' => ['required', 'string', 'max:1000'],
        ];
    }
}
