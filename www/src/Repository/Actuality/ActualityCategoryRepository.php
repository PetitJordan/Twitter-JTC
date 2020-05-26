<?php

namespace App\Repository\Actuality;

use App\Entity\Actuality\ActualityCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActualityCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActualityCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActualityCategory[]    findAll()
 * @method ActualityCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualityCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActualityCategory::class);
    }

    // /**
    //  * @return ActualityCategory[] Returns an array of ActualityCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActualityCategory
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
