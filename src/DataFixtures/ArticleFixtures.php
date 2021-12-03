<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article1 = new Article(
            "The Apple Watch Series 6 is still available for $100 off at Best Buy",
            "You can save big on the Apple Watch Series 6, PlayStation and Nintendo Switch games, Samsung’s Galaxy Buds 2, the Google Pixel 5A, the third-gen Echo Dot, the Bose QuietComfort 45, the Chromecast with Google TV, and RavPower chargers.",
            new DateTimeImmutable("2021-01-01 08:00:00"),
            new DateTime("2021-01-11 23:59:59"),
        );

        $article2 = new Article(
            "Apple Music’s terrible year in review is giving me serious Spotify Wrapped FOMO",
            "Spotify Wrapped is one of the music streaming service’s most popular features, but Apple Music still refuses to offer anything beyond a lackluster imitation, leaving subscribers feeling like they’re missing out on the December fun.",
            new DateTimeImmutable("2021-01-02 09:00:00"),
            new DateTime("2021-01-12 23:59:59"),
        );

        $article3 = new Article(
            "Apple wins in mobile price war -investor - Reuters.com",
            "Shares of Apple have rallied 33 percent in the past six months as investors see the iPhone maker as the main beneficiary of a price war where U.S. wireless service providers are buying the latest device but offering it at deep discounts to lure customers, say.",
            new DateTimeImmutable("2021-01-03 08:00:00"),
            new DateTime("2021-01-13 23:59:59"),
        );

        $article4 = new Article(
            "Futures jump after inflation-driven rout - Reuters",
            "Wall Street's main indexes were set to bounce back on Wednesday following a sharp selloff triggered by concerns over rising inflation and the new Omicron variant, while shares of Merck jumped on progress in approval of its COVID-19 pill.",
            new DateTimeImmutable("2021-01-04 08:00:00"),
            new DateTime("2021-01-14 23:59:59"),
        );

        $article5 = new Article(
            "Bad Bunny most-streamed artist on Spotify for second year running",
            "The Puerto Rican star beats Taylor Swift and Drake, while Olivia Rodrigo continues meteoric rise as Spotify and Apple Music announce statsSpotify and Apple Music, the two biggest players in music streaming, have announced the tracks and albums that have been.",
            new DateTimeImmutable("2021-01-05 08:00:00"),
            new DateTime("2021-01-15 23:59:59"),
        );

        $manager->persist($article1);
        $manager->persist($article2);
        $manager->persist($article3);
        $manager->persist($article4);
        $manager->persist($article5);
        $manager->flush();
    }
}