<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User(
                $faker->firstName,
                $faker->lastName,
                $faker->email,
                new DateTimeImmutable($faker->dateTime->format('Y-m-d H:i:s')),
            );

            $password = $this->userPasswordHasher->hashPassword($user, '1234');
            $user->changePassword($password);

            $manager->persist($user);
            $manager->flush();
        }
    }
}
