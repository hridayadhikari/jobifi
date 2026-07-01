<?php

namespace App\Http\Requests\Seeker;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'seeker';
    }

    public function rules(): array
    {
        return [
            'job_title'    => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'start_date'   => ['required', 'date'],
            'end_date'     => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current'   => ['sometimes', 'boolean'],
        ];
    }
}
