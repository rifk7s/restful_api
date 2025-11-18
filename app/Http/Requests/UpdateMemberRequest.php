<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('member');

        return [
            'student_id' => ['sometimes', 'string', Rule::unique('members')->ignore($memberId)],
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique('members')->ignore($memberId)],
            'phone' => ['sometimes', 'string', 'max:20'],
            'member_since' => ['sometimes', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.unique' => 'This student ID is already registered',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already registered',
            'member_since.date' => 'Please provide a valid date',
        ];
    }
}
