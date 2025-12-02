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
            'highlights.*.label' => ['required_with:highlights', 'string'],
        ];
    }
}
