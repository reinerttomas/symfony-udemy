<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Article;
use App\Exception\ORM\ORMStoreException;
use App\Form\ArticleUpdateRequest;
use App\Repository\ArticleRepository;
use DateTime;

class ArticleUpdateService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws ORMStoreException
     */
    public function updateFromRequest(Article $article, ArticleUpdateRequest $request): Article
    {
        $article
            ->changeTitle($request->title)
            ->changeContent($request->content)
            ->changeUpdatedAt(new DateTime())
            ->changePublishedAt($request->publishedAt);

        return $this->articleRepository->store($article);
    }
}