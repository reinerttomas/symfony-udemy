<?php
declare(strict_types=1);

namespace App\Utils\Enum;

interface EnumInterface
{
    /**
     * @return array<int, string|int>
     */
    public function getEnumValues(): array;

    /**
     * @return array<string, string|int>
     */
    public function getEnum(): array;
}
