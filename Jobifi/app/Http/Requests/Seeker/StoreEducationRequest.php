<?php

namespace App\Http\Requests\Seeker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth::check() && auth::user()->role === 'seeker';
    }

    public function rules(): array
    {
        return [
            'degree'      => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'start_year'  => ['required', 'digits:4', 'integer', 'min:1950', 'max:' . date('Y')],
            'end_year'    => ['nullable', 'digits:4', 'integer', 'gte:start_year'],
        ];
    }
}
