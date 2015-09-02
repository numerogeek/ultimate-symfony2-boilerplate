<?php

namespace Numerogeek\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numerogeek\BlogBundle\Entity\Post;

class PostRepository extends EntityRepository
{
    public function findLatest($limit = Post::NUM_ITEMS, Post $current = null)
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->select('p')
            ->where('p.publishedAt <= :now')->setParameter('now', new \DateTime())
            ->andWhere('p.online = :online')->setParameter('online', true)
        ;

        if (!empty($current)) {
            $qb->andWhere('p.id != :current')->setParameter('current', $current->getId());
            $qb->andWhere('p.category = :category')->setParameter('category', $current->getCategory());
        }

        return $qb->orderBy('p.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findNext(Post $post)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.publishedAt >= :current')->setParameter('current', $post->getPublishedAt())
            ->andWhere('p.online = :online')->setParameter('online', true)
            ->orderBy('p.publishedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function search($keyword, $limit = Post::NUM_ITEMS)
    {
        return $this
            ->createQueryBuilder('p')
            ->select('p')
            ->where('p.publishedAt <= :now')->setParameter('now', new \DateTime())
            ->andWhere('p.online = :online')->setParameter('online', true)
            ->andWhere('p.content LIKE :keyword OR p.title LIKE :keyword OR p.summary LIKE :keyword')->setParameter('keyword', '%'.$keyword.'%')
            ->orderBy('p.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}
