<?php
declare(strict_types=1);

namespace App\Services;

use App\Dto\UserCreateRequest;
use App\Entity\User;
use App\Exception\ORM\ORMStoreException;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateService
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
     * @throws ORMStoreException
     */
    public function createFromRequest(UserCreateRequest $request): User
    {
        $user = new User(
            $request->name,
            $request->surname,
            $request->email,
        );

        $password = $this->userPasswordHasher->hashPassword($user, $request->password);
        $user->changePassword($password);

        return $this->userRepository->store($user);
    }
}
