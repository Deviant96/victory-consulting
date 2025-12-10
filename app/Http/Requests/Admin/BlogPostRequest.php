<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('tags') && is_string($this->tags)) {
            $this->merge([
                'tags' => array_values(array_filter(array_map('trim', explode(',', $this->tags)))),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'category' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'string'],
            'author' => ['nullable', 'string', 'max:255'],
            'published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'translations' => ['sometimes', 'array'],
            'translations.*' => ['sometimes', 'array'],
            'translations.*.title' => ['nullable', 'string'],
            'translations.*.excerpt' => ['nullable', 'string'],
            'translations.*.content' => ['nullable', 'string'],
            'translations.*.author' => ['nullable', 'string'],
        ];
    }
}
