<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($this->route('service')),
            ],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'integer'],
            'price_note' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'published' => ['boolean'],
            'highlights' => ['nullable', 'array'],
            'highlights.*.label' => ['nullable', 'string'],
            'translations' => ['sometimes', 'array'],
            'translations.*' => ['sometimes', 'array'],
            'translations.*.title' => ['nullable', 'string'],
            'translations.*.summary' => ['nullable', 'string'],
            'translations.*.description' => ['nullable', 'string'],
            'translations.*.price_note' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'highlights.*.label.string' => 'Each highlight must be a valid text.',
        ];
    }

    protected function prepareForValidation()
    {
        // Filter out empty highlights before validation
        if ($this->has('highlights')) {
            $highlights = array_filter($this->highlights, function ($highlight) {
                return !empty($highlight['label']);
            });
            $this->merge([
                'highlights' => array_values($highlights), // Re-index array
            ]);
        }
    }
}
