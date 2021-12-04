<?php

namespace App\Repository;

use App\Entity\Article;
use App\Exception\ORM\ORMStoreException;
use App\Exception\Logic\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return array<int, Article>
     */
    public function list(): array
    {
        return $this->findAll();
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): Article
    {
        $article = $this->find($id);

        if ($article === null) {
            throw new NotFoundException('Article not found. ID: ' . $id);
        }

        return $article;
    }

    /**
     * @return array<int, Article>
     */
    public function getAllNotRemoved(): array
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where($qb->expr()->eq('a.isRemoved', ':isRemoved'))
            ->setParameter('isRemoved', false);

        /** @var array<int, Article> $result */
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * @throws ORMStoreException
     */
    public function store(Article $article): Article
    {
        $em = $this->getEntityManager();

        try {
            $em->persist($article);
            $em->flush();
        } catch (Throwable $t) {
            throw new ORMStoreException($t->getMessage());
        }

        return $article;
    }
}