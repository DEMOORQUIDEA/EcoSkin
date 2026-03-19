<?php

// compatibility helpers for Laravel helper removal

if (! function_exists('str_plural')) {
    /**
     * Get the plural form of an English noun.
     *
     * This helper used to exist in earlier Laravel versions.  Post‑Laravel 6 it
     * was removed in favor of the Str::plural() method.  A few old templates or
     * 3rd‑party packages may still call the global helper, causing a fatal error
     * such as "Call to undefined function str_plural()" when rendering views.
     *
     * Providing a small wrapper keeps those calls working and prevents the
     * products page from crashing (which was why DataTables showed the endless
     * "Cargando productos..." spinner).
     */
    function str_plural(string $value, int $count = 2): string
    {
        return \\Illuminate\\Support\\Str::plural($value, $count);
    }
}
