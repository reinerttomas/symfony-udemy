<?php
declare(strict_types=1);

namespace App\Utils;

class Arrays
{
    /**
     * @param string|int $needle
     * @param array<string|int, string|int> $array
     * @return bool
     */
    public static function containsValue(string|int $needle, array $array): bool
    {
        return in_array($needle, $array, true);
    }
}