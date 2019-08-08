<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    /**
     * @return Projet[]|array
     */
    public function findAll() {

        return $this->findBy([], ['order_index' => 'ASC']);
    }

    /**
     * @return int
     */
    public function getMaxOrder() {

        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
           ->orderBy('p.order_index', 'DESC')
           ->setMaxResults(1);

        $project = $qb->getQuery()->getOneOrNullResult();

        if($project) {
            return $project->getOrderIndex();
        }

        return 0;
    }

    /**
     * @param int   $order
     * @return Projet[]|array
     */
    public function findAllByOrderGreaterThan($order) {

        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
           ->where('p.order_index > :order')
           ->setParameter('order', $order);

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Projet[] Returns an array of Projet objects
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
    public function findOneBySomeField($value): ?Projet
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
