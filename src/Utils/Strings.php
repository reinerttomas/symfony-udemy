<?php
declare(strict_types=1);

namespace App\Utils;

class Strings
{
    public static function startsWith(string $haystack, string $needle): bool
    {
        return str_starts_with($haystack, $needle);
    }
}