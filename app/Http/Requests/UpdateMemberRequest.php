<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
        $memberId = $this->route('member');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'unique:members,email,'.$memberId],
            'phone' => ['sometimes', 'string', 'max:20'],
            'member_since' => ['sometimes', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already registered',
            'member_since.date' => 'Please provide a valid date',
        ];
    }
}
