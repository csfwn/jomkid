<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChildProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'display_name' => ['required', 'string', 'max:40'],
            'birth_year' => ['nullable', 'integer', 'between:2016,2023'],
            'avatar_key' => ['required', Rule::in(['owl-indigo', 'owl-coral', 'owl-yellow'])],
            'leaderboard_opt_in' => ['sometimes', 'boolean'],
        ];
    }
}
