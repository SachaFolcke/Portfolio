<?php

namespace App\Repository;

use App\Entity\TimelineElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TimelineElement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimelineElement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimelineElement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimelineElementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TimelineElement::class);
    }

    /**
     * @return TimelineElement[]|array
     */
    public function findAll() {

        return $this->findBy([], ['order_index' => 'ASC']);
    }

    /**
     * @return int
     */
    public function getMaxOrder() {

        $qb = $this->createQueryBuilder('t');

        $qb->select('t')
            ->orderBy('t.order_index', 'DESC')
            ->setMaxResults(1);

        $element = $qb->getQuery()->getOneOrNullResult();

        if($element) {
            return $element->getOrderIndex();
        }

        return 0;
    }

    /**
     * @param int   $order
     * @return TimelineElement[]|array
     */
    public function findAllByOrderGreaterThan($order) {

        $qb = $this->createQueryBuilder('p');

        $qb->select('t')
            ->where('t.order_index > :order')
            ->setParameter('order', $order);

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return TimelineElement[] Returns an array of TimelineElement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TimelineElement
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
