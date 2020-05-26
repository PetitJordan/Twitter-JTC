<?php

namespace App\Repository\Actuality;

use App\Entity\Actuality\AddPush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AddPush|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddPush|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddPush[]    findAll()
 * @method AddPush[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddPushRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddPush::class);
    }

    // /**
    //  * @return AddPush[] Returns an array of AddPush objects
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
    public function findOneBySomeField($value): ?AddPush
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
