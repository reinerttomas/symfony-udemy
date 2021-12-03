<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Article;
use DateTime;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateArticleRequest
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

    #[Pure]
    public static function from(Article $article): UpdateArticleRequest
    {
        $request = new UpdateArticleRequest();
        $request->title = $article->getTitle();
        $request->content = $article->getContent();
        $request->publishedAt = $article->getPublishedAt();

        return $request;
    }
}