<?php

namespace App\Repository;

use App\Entity\SkillRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SkillRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillRow[]    findAll()
 * @method SkillRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRowRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SkillRow::class);
    }

    // /**
    //  * @return SkillRow[] Returns an array of SkillRow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SkillRow
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
