<?php
declare(strict_types=1);

namespace App\Entity;

use App\Exception\Logic\InvalidArgumentException;
use App\Utils\Arrays;
use App\Utils\Enum\AbstractEnum;

class UserRole extends AbstractEnum
{
    private const ROLE_USER = 'USER';

    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!Arrays::containsValue($value, $this->getEnumValues())) {
            throw new InvalidArgumentException('Unsupported UserRole: ' . $value);
        }

        $this->value = $value;
    }

    public static function user(): UserRole
    {
        return new UserRole(self::ROLE_USER);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    protected function getEnumPrefix(): string
    {
        return 'ROLE_';
    }
}