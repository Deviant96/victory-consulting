<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function index(): View
    {
        $languages = Language::orderByDesc('is_active')
            ->orderBy('label')
            ->paginate(15);

        return view('admin.languages.index', compact('languages'));
    }

    public function create(): View
    {
        return view('admin.languages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:10', 'unique:languages,code'],
            'label' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Language::create($data);

        return redirect()->route('admin.languages.index')->with('success', 'Language created successfully.');
    }

    public function edit(Language $language): View
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:10', 'unique:languages,code,' . $language->id],
            'label' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $fallback = config('app.fallback_locale', 'en');

        $data['is_active'] = $request->boolean('is_active');

        if ($language->code === $fallback) {
            $data['is_active'] = true;
        }

        $language->update($data);

        return redirect()->route('admin.languages.index')->with('success', 'Language updated successfully.');
    }

    public function destroy(Language $language): RedirectResponse
    {
        if ($language->code === config('app.fallback_locale', 'en')) {
            return redirect()->route('admin.languages.index')->with('error', 'The default language cannot be removed.');
        }

        $language->delete();

        return redirect()->route('admin.languages.index')->with('success', 'Language removed.');
    }
}
