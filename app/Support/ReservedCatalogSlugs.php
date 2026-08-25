<?php

namespace App\Support;

class ReservedCatalogSlugs
{
    /**
     * @return list<string>
     */
    public static function all(): array
    {
        /** @var list<string> $slugs */
        $slugs = config('catalog.reserved_slugs', []);

        return $slugs;
    }

    public static function contains(string $slug): bool
    {
        return in_array($slug, self::all(), true);
    }

    /**
     * Route::where() pattern that never matches reserved first-path segments.
     */
    public static function routePattern(): string
    {
        $alternation = implode('|', array_map(
            static fn (string $slug): string => preg_quote($slug, '/'),
            self::all(),
        ));

        return "^(?!(?:{$alternation})$)[a-z0-9]+(?:-[a-z0-9]+)*$";
    }
}
