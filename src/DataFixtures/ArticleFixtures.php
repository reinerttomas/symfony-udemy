<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $article = new Article(
                $faker->sentence,
                $faker->text,
                new DateTimeImmutable($faker->dateTimeBetween('-1 week')->format('Y-m-d H:i:s')),
                new DateTime($faker->dateTimeBetween('now', '+1 week')->format('Y-m-d H:i:s')),
            );

            $manager->persist($article);
            $manager->flush();
        }
    }
}