<?php
declare(strict_types=1);

namespace App\Utils\Enum;

interface EnumInterface
{
    public function getEnumValues(): array;

    public function getEnum(): array;
}