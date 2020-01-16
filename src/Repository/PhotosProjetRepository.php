<?php

namespace App\Repository;

use App\Entity\PhotosProjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PhotosProjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotosProjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotosProjet[]    findAll()
 * @method PhotosProjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotosProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotosProjet::class);
    }

    // /**
    //  * @return PhotosProjet[] Returns an array of PhotosProjet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhotosProjet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
