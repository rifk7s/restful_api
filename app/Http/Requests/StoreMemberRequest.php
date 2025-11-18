<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:members,email'],
            'phone' => ['required', 'string', 'max:20'],
            'member_since' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Member name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already registered',
            'phone.required' => 'Phone number is required',
            'member_since.required' => 'Member since date is required',
            'member_since.date' => 'Please provide a valid date',
        ];
    }
}
