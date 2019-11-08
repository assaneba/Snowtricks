<?php

namespace App\Repository;

use App\Entity\GroupOfTricks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GroupOfTricks|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupOfTricks|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupOfTricks[]    findAll()
 * @method GroupOfTricks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupOfTricksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupOfTricks::class);
    }

    // /**
    //  * @return GroupOfTricks[] Returns an array of GroupOfTricks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupOfTricks
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
