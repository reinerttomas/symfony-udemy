<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserChangePasswordRequest
{
    #[Assert\NotBlank]
    public string $oldPassword;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 8,
        max: 32,
        minMessage: "Password must be at least {{ limit }} characters long",
        maxMessage: "Password cannot be longer than {{ limit }} characters",
    )]
    public string $newPassword;
}
