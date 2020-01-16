<?php

namespace App\Repository;

use App\Entity\SkillCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SkillCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillCategory::class);
    }

    public function findAll() {

        return $this->findBy([], ['order_index' => 'ASC']);
    }

    /**
     * @return int
     */
    public function getMaxOrder() {

        $qb = $this->createQueryBuilder('sc');

        $qb->select('sc')
            ->orderBy('sc.order_index', 'DESC')
            ->setMaxResults(1);

        $sc = $qb->getQuery()->getOneOrNullResult();

        if($sc) {
            return $sc->getOrderIndex();
        }

        return 0;
    }

    /**
     * @param int   $order
     * @return SkillCategory[]|array
     */
    public function findAllByOrderGreaterThan($order) {

        $qb = $this->createQueryBuilder('sc');

        $qb->select('sc')
            ->where('sc.order_index > :order')
            ->setParameter('order', $order);

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return SkillCategory[] Returns an array of SkillCategory objects
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
    public function findOneBySomeField($value): ?SkillCategory
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
