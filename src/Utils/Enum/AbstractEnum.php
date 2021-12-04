<?php
declare(strict_types=1);

namespace App\Utils\Enum;

use App\Utils\Strings;
use ReflectionClass;

abstract class AbstractEnum implements EnumInterface
{
    public function getEnumValues(): array
    {
        $enumArray = [];

        foreach (self::getEnum() as $enum) {
            $enumArray[] = $enum;
        }

        return $enumArray;
    }

    public function getEnum(): array
    {
        $class = new ReflectionClass(self::class);
        $constArray = [];

        /**
         * @var string $constName
         * @var string|int $constValue
         */
        foreach ($class->getConstants() as $constName => $constValue) {
            if (Strings::startsWith($constName, $this->getEnumPrefix())) {
                $constArray[$constName] = $constValue;
            }
        }

        return $constArray;
    }

    abstract protected function getEnumPrefix(): string;
}
