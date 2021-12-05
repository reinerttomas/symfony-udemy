<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserCreateRequest
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public string $surname;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 8,
        max: 32,
        minMessage: "Password must be at least {{ limit }} characters long",
        maxMessage: "Password cannot be longer than {{ limit }} characters",
    )]
    public string $password;
}
