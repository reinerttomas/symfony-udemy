<?php
declare(strict_types=1);

namespace App\Services;

use App\Dto\UserChangePasswordRequest;
use App\Entity\User;
use App\Exception\ORM\ORMStoreException;
use App\Exception\Runtime\AuthenticationException;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher,
    ) {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @throws AuthenticationException
     * @throws ORMStoreException
     */
    public function changeFromRequest(User $user, UserChangePasswordRequest $request): User
    {
        $isPasswordValid = $this->userPasswordHasher->isPasswordValid($user, $request->oldPassword);

        if ($isPasswordValid === false) {
            throw new AuthenticationException('Password is not valid');
        }

        $password = $this->userPasswordHasher->hashPassword($user, $request->newPassword);
        $user->changePassword($password)
            ->updated();

        return $this->userRepository->store($user);
    }
}
