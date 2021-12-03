<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Article;
use App\Exception\Logic\NotFoundException;
use App\Repository\ArticleRepository;

class FetchArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @return array<int, Article>
     */
    public function list(): array
    {
        return $this->articleRepository->list();
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): Article
    {
        return $this->articleRepository->get($id);
    }

    /**
     * @return array<int, Article>
     */
    public function getAllNotRemoved(): array
    {
        return $this->articleRepository->getAllNotRemoved();
    }
}