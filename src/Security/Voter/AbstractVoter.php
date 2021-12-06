<?php
declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\UserRole;
use App\Utils\Arrays;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return Arrays::containsValue($attribute, $this->getAttributes());
    }

    protected function isUserInstance(TokenInterface $token): bool
    {
        $user = $token->getUser();

        if ($user instanceof UserInterface) {
            return true;
        }

        return false;
    }

    protected function isUserInAllowedRole(TokenInterface $token): bool
    {
        /** @var UserInterface $user */
        $user = $token->getUser();

        foreach ($user->getRoles() as $role) {
            foreach ($this->getAllowedRoles() as $userRole) {
                if ($userRole->getValue() === $role) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return array<int, UserRole>
     */
    abstract protected function getAllowedRoles(): array;

    /**
     * @return array<int, string>
     */
    abstract protected function getAttributes(): array;
}
