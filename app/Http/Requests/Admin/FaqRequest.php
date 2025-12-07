<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'published' => ['boolean'],
            'translations' => ['sometimes', 'array'],
            'translations.*' => ['sometimes', 'array'],
            'translations.*.question' => ['nullable', 'string'],
            'translations.*.answer' => ['nullable', 'string'],
        ];
    }
}
