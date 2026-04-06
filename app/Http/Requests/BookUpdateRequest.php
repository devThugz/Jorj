<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUpdateRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'author' => [
                'required',
                'string',
                'max:255',
            ],
            'isbn' => [
                'required',
                'string',
                Rule::unique('books', 'isbn')->ignore($bookId),
            ],
            'publisher' => [
                'required',
                'string',
                'max:255',
            ],
            'published_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The book title is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            
            'author.required' => 'The author name is required.',
            'author.string' => 'The author must be a valid string.',
            'author.max' => 'The author may not be greater than 255 characters.',
            
            'isbn.required' => 'The ISBN is required.',
            'isbn.unique' => 'This ISBN has already been taken.',
            
            'publisher.required' => 'The publisher name is required.',
            'publisher.string' => 'The publisher must be a valid string.',
            'publisher.max' => 'The publisher may not be greater than 255 characters.',
            
            'published_date.required' => 'The published date is required.',
            'published_date.date' => 'Please enter a valid date.',
            'published_date.before_or_equal' => 'The published date cannot be in the future.',
            
            'description.max' => 'The description may not be greater than 1000 characters.',
            
            'category_id.required' => 'Please select a category.',
            'category_id.integer' => 'Invalid category selected.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('isbn')) {
            $this->merge([
                'isbn' => trim($this->isbn),
            ]);
        }
    }
}
