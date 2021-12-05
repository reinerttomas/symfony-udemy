<?php
declare(strict_types=1);

namespace App\Services;

use App\Dto\UserUpdateRequest;
use App\Entity\User;
use App\Exception\ORM\ORMStoreException;
use App\Repository\UserRepository;
use DateTime;

class UserUpdateService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ORMStoreException
     */
    public function updateFromRequest(User $user, UserUpdateRequest $request): User
    {
        $user
            ->changeName($request->name, $request->surname)
            ->changeEmail($request->email)
            ->changeUpdatedAt(new DateTime());

        return $this->userRepository->store($user);
    }
}
