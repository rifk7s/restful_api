<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
        $bookId = $this->route('book');

        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'author' => ['sometimes', 'string', 'max:255'],
            'isbn' => ['sometimes', 'string', 'unique:books,isbn,'.$bookId],
            'published_year' => ['sometimes', 'integer', 'min:1000', 'max:'.(date('Y') + 1)],
            'available' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'isbn.unique' => 'This ISBN already exists',
            'published_year.min' => 'Published year must be at least 1000',
            'published_year.max' => 'Published year cannot be in the future',
        ];
    }
}
