<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'unique:books,isbn'],
            'published_year' => ['required', 'integer', 'min:1000', 'max:'.(date('Y') + 1)],
            'available' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Book title is required',
            'author.required' => 'Author name is required',
            'isbn.required' => 'ISBN is required',
            'isbn.unique' => 'This ISBN already exists',
            'published_year.required' => 'Published year is required',
            'published_year.min' => 'Published year must be at least 1000',
            'published_year.max' => 'Published year cannot be in the future',
        ];
    }
}
