<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exception\Logic\NotFoundException;
use App\Exception\ORM\ORMStoreException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Throwable;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return array<int, User>
     */
    public function list(): array
    {
        return $this->findAll();
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): User
    {
        $user = $this->find($id);

        if ($user === null) {
            throw new NotFoundException('User not found. ID: ' . $id);
        }

        return $user;
    }

    /**
     * @return array<int, User>
     */
    public function getAllWithActive(): array
    {
        $qb = $this->createQueryBuilder('u');

        return $qb->getQuery()->getResult();
    }

    /**
     * @throws ORMStoreException
     */
    public function store(User $user): User
    {
        $em = $this->getEntityManager();

        try {
            $em->persist($user);
            $em->flush();
        } catch (Throwable $t) {
            throw new ORMStoreException($t->getMessage());
        }

        return $user;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
//    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
//    {
//        if (!$user instanceof User) {
//            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
//        }
//
//        $user->setPassword($newHashedPassword);
//        $this->_em->persist($user);
//        $this->_em->flush();
//    }
}
