<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateRequest
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public string $surname;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Pure]
    public static function from(User $user): UserUpdateRequest
    {
        $request = new UserUpdateRequest();
        $request->name = $user->getName();
        $request->surname = $user->getSurname();
        $request->email = $user->getEmail();

        return $request;
    }
}
