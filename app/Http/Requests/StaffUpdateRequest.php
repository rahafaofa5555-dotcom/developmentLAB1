<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // ignore(...) lets a staff member keep their own email / phone number
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email',
                Rule::unique('staff', 'email')->ignore($this->route('id'))],
            'password' => 'sometimes|required|string|min:8',
            'role' => 'sometimes|required|string',
            'phone_number' => ['sometimes', 'required', 'string',
                Rule::unique('staff', 'phone_number')->ignore($this->route('id'))],
        ];
    }
}
