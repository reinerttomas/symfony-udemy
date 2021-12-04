<?php
declare(strict_types=1);

namespace App\Dto;

use DateTime;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleCreateRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: "Article title must be at least {{ limit }} characters long",
        maxMessage: "Article title cannot be longer than {{ limit }} characters",
    )]
    public string $title;

    #[Assert\NotBlank]
    public string $content;

    #[Assert\NotBlank]
    #[Assert\Type(DateTimeImmutable::class)]
    public DateTimeImmutable $createdAt;

    #[Assert\NotBlank]
    #[Assert\Type(DateTime::class)]
    public DateTime $publishedAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->publishedAt = new DateTime();
    }
}
