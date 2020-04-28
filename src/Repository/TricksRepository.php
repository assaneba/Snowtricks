<?php

namespace App\Repository;

use App\Entity\Tricks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Tricks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tricks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tricks[]    findAll()
 * @method Tricks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TricksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tricks::class);
    }

    /**
     * @param $page
     * @param $limit
     * @return Paginator
     */
    public function paginate($page, $limit){
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

        $query = $this->createQueryBuilder('t')
                      ->addOrderBy('t.createdAt', 'DESC')
                      ->getQuery()
                      ->setFirstResult(($page - 1) * $limit)
                      ->setMaxResults($limit);

        return new Paginator($query);
    }

    /**
     * @return integer - Number of tricks
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function totalTricks() {
        //  Query how many rows are there in the Trick table
        $query = $this->createQueryBuilder('t')
                      ->select('count(t.id)')
                      ->getQuery()
                      ->getSingleScalarResult();

        return $query;
    }

}
