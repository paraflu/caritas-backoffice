<?php

/**
 * Returns the translations array.
 * These locales will be sent to Vue via the Inertia's share method.
 *
 * @param $locale string - The locale whose translations you want to find
 */
function translations(string $locale): array
{
    $translationFiles = File::files(base_path("resources/lang/$locale"));

    return collect($translationFiles)
        ->map(fn ($file) => [$file->getFilenameWithoutExtension() => require($file)])
        ->collapse()
        ->toArray();
}
