<?php
declare(strict_types=1);

namespace App\Services;

use App\Dto\ArticleCreateRequest;
use App\Entity\Article;
use App\Exception\ORM\ORMStoreException;
use App\Repository\ArticleRepository;

class ArticleCreateService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws ORMStoreException
     */
    public function createFromRequest(ArticleCreateRequest $request): Article
    {
        $article = new Article(
            $request->title,
            $request->content,
            $request->publishedAt,
        );

        return $this->articleRepository->store($article);
    }
}
