<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\Article;
use DateTime;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleUpdateRequest
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
    #[Assert\Type(DateTime::class)]
    public DateTime $publishedAt;

    #[Pure]
    public static function from(Article $article): ArticleUpdateRequest
    {
        $request = new ArticleUpdateRequest();
        $request->title = $article->getTitle();
        $request->content = $article->getContent();
        $request->publishedAt = $article->getPublishedAt();

        return $request;
    }
}
