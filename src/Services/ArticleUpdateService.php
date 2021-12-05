<?php
declare(strict_types=1);

namespace App\Services;

use App\Dto\ArticleUpdateRequest;
use App\Entity\Article;
use App\Exception\ORM\ORMStoreException;
use App\Repository\ArticleRepository;

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
            ->changePublishedAt($request->publishedAt)
            ->updated();

        return $this->articleRepository->store($article);
    }
}
