<?php

namespace App\Repository\Actuality;

use App\Entity\Actuality\ActualityTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActualityTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActualityTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActualityTag[]    findAll()
 * @method ActualityTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualityTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActualityTag::class);
    }

    // /**
    //  * @return ActualityTag[] Returns an array of ActualityTag objects
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
    public function findOneBySomeField($value): ?ActualityTag
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
