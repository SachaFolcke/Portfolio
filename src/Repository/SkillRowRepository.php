<?php

namespace App\Repository;

use App\Entity\SkillRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SkillRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRowRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SkillRow::class);
    }

    public function findAll() {

        return $this->findBy([], ['order_index' => 'ASC']);
    }

    /**
     * @param int   $catId
     * @return int
     */
    public function getMaxOrder($catId) {

        $qb = $this->createQueryBuilder('sr');

        $qb->select('sr')
            ->where('sr.category = :catId')
            ->setParameter('catId', $catId)
            ->orderBy('sr.order_index', 'DESC')
            ->setMaxResults(1);

        $sr = $qb->getQuery()->getOneOrNullResult();

        if($sr) {
            return $sr->getOrderIndex();
        }

        return 0;
    }

    /**
     * @param int   $order
     * @param       $catId
     * @return SkillRow[]|array
     */
    public function findAllByOrderGreaterThan($order, $catId) {

        $qb = $this->createQueryBuilder('sr');

        $qb->select('sr')
            ->where('sr.order_index > :order')
            ->setParameter('order', $order)
            ->andWhere('sr.category = :catId')
            ->setParameter('catId', $catId);

        return $qb->getQuery()->getResult();
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
