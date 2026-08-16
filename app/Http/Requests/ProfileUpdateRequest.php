<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'last_name'      => ['nullable', 'string', 'max:100'],
            'middle_initial' => ['nullable', 'string', 'max:10'],
            'suffix'         => ['nullable', 'string', 'max:20'],
            'contact'        => ['nullable', 'string', 'max:20'],
            'gender'         => ['nullable', 'string', 'in:Male,Female'],
            'classification' => ['nullable', 'string', 'in:Local,Domestic,Foreign'],
            'dob'            => ['nullable', 'date'],
            'email'          => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
