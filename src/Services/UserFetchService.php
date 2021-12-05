<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Exception\Logic\NotFoundException;
use App\Repository\UserRepository;

class UserFetchService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array<int, User>
     */
    public function list(): array
    {
        return $this->userRepository->list();
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): User
    {
        return $this->userRepository->get($id);
    }

    /**
     * @return array<int, User>
     */
    public function getAllWithActive(): array
    {
        return $this->userRepository->getAllWithActive();
    }
}
