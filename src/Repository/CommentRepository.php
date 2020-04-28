<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use function is_numeric;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @return integer - number of comments for a Trick
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function totalComments() {
        //  Query how many rows are there in the Comment table
        $query = $this->createQueryBuilder('c')
                      ->select('count(c.id)')
                      ->getQuery()
                      ->getSingleScalarResult();

        return $query;
    }

    /**
     * @param $page
     * @param $limit
     * @return Paginator
     */
    public function paginate($page, $limit) {
        if (!is_numeric($page)) {
            throw new \InvalidArgumentException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }

        if (!is_numeric($limit)) {
            throw new \InvalidArgumentException(
                'La valeur de l\'argument $limit est incorrecte (valeur : ' . $limit . ').'
            );
        }

        $query = $this->createQueryBuilder('c')
                      ->addOrderBy('c.createdAt', 'DESC')
                      ->where('c.published = true')
                      ->getQuery()
                      ->setFirstResult(($page - 1) * $limit)
                      ->setMaxResults($limit);

        return new Paginator($query);
    }


    /**
     * @return array
     */
    public function unpublished() {
        $query = $this->createQueryBuilder('c')
            ->addOrderBy('c.createdAt', 'DESC')
            ->where('c.published = false')
            ->getQuery()
            ->execute();

        return $query;
    }

}
