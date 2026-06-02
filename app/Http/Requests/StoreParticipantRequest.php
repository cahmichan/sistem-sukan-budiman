<?php

namespace App\Http\Requests;

use App\Models\Participant;
use App\Models\Sport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreParticipantRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $age = (int) $this->input('age');
        $category = Participant::categoryForAge($age);
        $isChild = $age > 0 && $category === 'Kanak-Kanak';

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('participants')->where(fn ($query) => $query->where('phone', $this->normalizedPhone())),
            ],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^(\\+?6?01)[0-9]-?[0-9]{7,8}$/'],
            'house_id' => ['required', 'exists:houses,id'],
            'sport_id' => [
                'required',
                Rule::exists('sports', 'id')->where('is_active', true),
                function (string $attribute, mixed $value, \Closure $fail) use ($category) {
                    $sport = Sport::find($value);

                    if ($sport && $category && ! $sport->compatibleWithCategory($category)) {
                        $fail('Acara yang dipilih tidak sesuai dengan kategori peserta.');
                    }
                },
            ],
            'guardian_name' => [$isChild ? 'required' : 'nullable', 'string', 'max:255'],
            'guardian_phone' => [$isChild ? 'required' : 'nullable', 'string', 'max:20', 'regex:/^(\\+?6?01)[0-9]-?[0-9]{7,8}$/'],
            'guardian_relationship' => [$isChild ? 'required' : 'nullable', 'string', 'max:100'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $age = (int) $this->input('age');

        $this->merge([
            'name' => Str::of($this->input('name'))->squish()->toString(),
            'phone' => $this->normalizePhone($this->input('phone')),
            'guardian_phone' => $this->normalizePhone($this->input('guardian_phone')),
            'category' => $age > 0 ? Participant::categoryForAge($age) : null,
        ]);
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Pendaftaran dengan nama dan nombor telefon ini telah wujud.',
            '*.required' => 'Medan ini wajib diisi.',
            '*.regex' => 'Sila masukkan nombor telefon Malaysia yang sah.',
            'sport_id.exists' => 'Acara yang dipilih tidak tersedia.',
            'sport_id' => 'Acara yang dipilih tidak sesuai dengan kategori umur peserta.',
        ];
    }

    private function normalizedPhone(): ?string
    {
        return $this->normalizePhone($this->input('phone'));
    }

    private function normalizePhone(?string $phone): ?string
    {
        if (blank($phone)) {
            return $phone;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($digits, '60')) {
            return '0'.substr($digits, 2);
        }

        return $digits;
    }
}
