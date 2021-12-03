<?php
declare(strict_types=1);

namespace App\Form;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class CreateArticleRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: "Article title must be at least {{ limit }} characters long",
        maxMessage: "Article title cannot be longer than {{ limit }} characters"
    )]
    public string $title;

    #[Assert\NotBlank]
    public string $content;

    #[Assert\NotBlank]
    #[Assert\Type(DateTime::class)]
    public DateTime $publishedAt;

    public function __construct()
    {
        $this->publishedAt = new DateTime();
    }
}