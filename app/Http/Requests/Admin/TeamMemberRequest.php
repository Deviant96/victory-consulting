<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'linkedin' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'expertise' => ['nullable', 'array'],
            'expertise.*' => ['nullable', 'string'],
        ];
    }
}
