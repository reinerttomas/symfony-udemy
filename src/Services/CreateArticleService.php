<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Article;
use App\Exception\ORM\ORMStoreException;
use App\Form\CreateArticleRequest;
use App\Repository\ArticleRepository;
use DateTimeImmutable;

class CreateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws ORMStoreException
     */
    public function createFromRequest(CreateArticleRequest $request): Article
    {
        $article = new Article(
            $request->title,
            $request->content,
            new DateTimeImmutable(),
            $request->publishedAt,
        );

        return $this->articleRepository->store($article);
    }
}