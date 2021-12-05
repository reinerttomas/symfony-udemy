<?php
declare(strict_types=1);

namespace App\Utils;

use Symfony\Component\String\UnicodeString;

class Strings
{
    public static function unicode(?string $string = ''): UnicodeString
    {
        return new UnicodeString($string ?? '');
    }
}
