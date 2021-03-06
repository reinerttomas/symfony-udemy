<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Article;
use App\Exception\ORM\ORMStoreException;
use App\Repository\ArticleRepository;
use DateTime;

class ArticleRemoveService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws ORMStoreException
     */
    public function remove(Article $article): void
    {
        $article
            ->markAsRemoved()
            ->changeUpdatedAt(new DateTime());

        $this->articleRepository->store($article);
    }
}
