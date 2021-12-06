<?php
declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\UserRole;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ArticleVoter extends AbstractVoter
{
    public const VIEW = 'ARTICLE_VIEW';
    public const CREATE = 'ARTICLE_CREATE';
    public const UPDATE = 'ARTICLE_UPDATE';
    public const DELETE = 'ARTICLE_DELETE';

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if (!$this->isUserInstance($token)) {
            return false;
        }

        if (!$this->isUserInAllowedRole($token)) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return true;

                // no break
            case self::CREATE:
                return true;

                // no break
            case self::UPDATE:
                return true;

                // no break
            case self::DELETE:
                return true;
                // no break
        }

        return false;
    }

    protected function getAllowedRoles(): array
    {
        return [
            UserRole::blogger(),
        ];
    }

    protected function getAttributes(): array
    {
        return [
            self::VIEW,
            self::CREATE,
            self::UPDATE,
            self::DELETE,
        ];
    }
}
