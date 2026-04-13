<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\App;

trait HasLocalizedAttributes
{
    protected function localizedValue(mixed $value): mixed
    {
        if (! is_string($value) || $value === '') {
            return $value;
        }

        $decoded = json_decode($value, true);
        if (! is_array($decoded)) {
            return $value;
        }

        $locale = App::getLocale();
        $fallbacks = array_values(array_unique([$locale, 'fr', 'en', 'ar']));

        foreach ($fallbacks as $candidate) {
            $candidateValue = $decoded[$candidate] ?? null;
            if (is_string($candidateValue) && trim($candidateValue) !== '') {
                return $candidateValue;
            }
        }

        return collect($decoded)
            ->first(fn ($item) => is_string($item) && trim($item) !== '') ?? '';
    }
}

