<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class TranslationController extends Controller
{
    public function index(): View
    {
        $translationKeys = TranslationKey::with(['values'])
            ->orderBy('group')
            ->orderBy('key')
            ->paginate(15);

        $groups = TranslationKey::select('group')
            ->distinct()
            ->pluck('group')
            ->filter()
            ->values();

        $languages = Language::orderBy('label')->get();
        $fallbackLocale = config('app.fallback_locale', 'en');

        // Attach a friendly preview of the fallback language to speed up scanning
        $translationKeys->getCollection()->transform(function (TranslationKey $translationKey) use ($fallbackLocale) {
            $translationKey->preview = Str::limit($translationKey->valueForLocale($fallbackLocale) ?? '', 70);

            return $translationKey;
        });

        return view('admin.translations.index', compact('translationKeys', 'languages', 'fallbackLocale', 'groups'));
    }

    public function create(): View
    {
        $languages = Language::orderBy('label')->get();
        $translationKey = new TranslationKey();
        $translationKey->setRelation('values', collect());

        return view('admin.translations.create', compact('languages', 'translationKey'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:translation_keys,key'],
            'group' => ['nullable', 'string', 'max:255'],
            'translations' => ['array'],
        ]);

        $translationKey = TranslationKey::create([
            'key' => $data['key'],
            'group' => $data['group'] ?? null,
        ]);

        $this->syncTranslations($translationKey, $data['translations'] ?? []);

        return redirect()->route('admin.translations.index')->with('success', 'Translation key created successfully.');
    }

    public function edit(TranslationKey $translation): View
    {
        $languages = Language::orderBy('label')->get();
        $translation->load('values');

        return view('admin.translations.edit', [
            'translationKey' => $translation,
            'languages' => $languages,
        ]);
    }

    public function update(Request $request, TranslationKey $translation): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:translation_keys,key,' . $translation->id],
            'group' => ['nullable', 'string', 'max:255'],
            'translations' => ['array'],
        ]);

        $translation->update([
            'key' => $data['key'],
            'group' => $data['group'] ?? null,
        ]);

        $this->syncTranslations($translation, $data['translations'] ?? []);

        return redirect()->route('admin.translations.edit', $translation)->with('success', 'Translations updated successfully.');
    }

    protected function syncTranslations(TranslationKey $translationKey, array $translations): void
    {
        $languages = Language::pluck('code')->all();

        foreach ($languages as $languageCode) {
            $value = $translations[$languageCode] ?? null;

            if ($value === null || $value === '') {
                TranslationValue::where('translation_key_id', $translationKey->id)
                    ->where('language_code', $languageCode)
                    ->delete();

                continue;
            }

            TranslationValue::updateOrCreate(
                [
                    'translation_key_id' => $translationKey->id,
                    'language_code' => $languageCode,
                ],
                [
                    'value' => $value,
                ]
            );
        }
    }

    public function inlineUpdate(Request $request, TranslationKey $translation): JsonResponse
    {
        $data = $request->validate([
            'language_code' => ['required', 'string', 'exists:languages,code'],
            'value' => ['nullable', 'string'],
        ]);

        $this->syncTranslations($translation, [$data['language_code'] => $data['value']]);

        $fallbackLocale = config('app.fallback_locale', 'en');
        $translation->load('values');

        return response()->json([
            'status' => 'ok',
            'preview' => Str::limit($translation->valueForLocale($fallbackLocale) ?? '', 70),
        ]);
    }

    public function export(): Response
    {
        $languages = Language::orderBy('label')->get();
        $translationKeys = TranslationKey::with(['values'])
            ->orderBy('group')
            ->orderBy('key')
            ->get();

        // Build CSV content
        $csvData = [];
        
        // Header row
        $header = ['Group', 'Key'];
        foreach ($languages as $language) {
            $header[] = $language->label . ' (' . strtoupper($language->code) . ')';
        }
        $csvData[] = $header;

        // Data rows
        foreach ($translationKeys as $translationKey) {
            $row = [
                $translationKey->group ?? '',
                $translationKey->key,
            ];

            foreach ($languages as $language) {
                $value = $translationKey->values->firstWhere('language_code', $language->code);
                $row[] = $value ? $value->value : '';
            }

            $csvData[] = $row;
        }

        // Generate CSV string
        $output = fopen('php://temp', 'r+');
        foreach ($csvData as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        $fileName = 'translations_' . date('Y-m-d_His') . '.csv';

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'], // 10MB max
        ]);

        $file = $request->file('csv_file');
        $languages = Language::pluck('code', 'label')->all();
        
        // Read CSV file
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);
        
        if (!$header || count($header) < 2) {
            return redirect()->route('admin.translations.index')
                ->with('error', 'Invalid CSV format. The file must contain at least Group and Key columns.');
        }

        // Map header columns to language codes
        $languageMap = [];
        foreach ($header as $index => $columnName) {
            if ($index < 2) continue; // Skip Group and Key columns
            
            // Try to extract language code from column name like "English (EN)"
            if (preg_match('/\(([A-Z]{2})\)/', $columnName, $matches)) {
                $code = strtolower($matches[1]);
                if (in_array($code, array_values($languages))) {
                    $languageMap[$index] = $code;
                }
            }
        }

        $imported = 0;
        $updated = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 2 || empty($row[1])) {
                    continue; // Skip invalid rows
                }

                $group = $row[0] ?: null;
                $key = $row[1];

                // Find or create translation key
                $translationKey = TranslationKey::firstOrCreate(
                    ['key' => $key],
                    ['group' => $group]
                );

                $isNew = $translationKey->wasRecentlyCreated;
                
                // Update group if it changed
                if (!$isNew && $translationKey->group !== $group) {
                    $translationKey->update(['group' => $group]);
                }

                // Import translations
                $translations = [];
                foreach ($languageMap as $columnIndex => $languageCode) {
                    if (isset($row[$columnIndex])) {
                        $translations[$languageCode] = $row[$columnIndex];
                    }
                }

                $this->syncTranslations($translationKey, $translations);

                if ($isNew) {
                    $imported++;
                } else {
                    $updated++;
                }
            }

            DB::commit();
            fclose($handle);

            $message = "Import successful! Created {$imported} new translations, updated {$updated} existing translations.";
            return redirect()->route('admin.translations.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            
            return redirect()->route('admin.translations.index')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
