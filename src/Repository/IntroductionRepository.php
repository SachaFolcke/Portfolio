<?php

namespace App\Repository;

use App\Entity\Introduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Introduction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Introduction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Introduction[]    findAll()
 * @method Introduction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntroductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Introduction::class);
    }

    // /**
    //  * @return Introduction[] Returns an array of Introduction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Introduction
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
