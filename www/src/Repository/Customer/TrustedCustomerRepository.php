<?php

namespace App\Repository\Customer;

use App\Entity\Customer\TrustedCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrustedCustomer|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrustedCustomer|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrustedCustomer[]    findAll()
 * @method TrustedCustomer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrustedCustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrustedCustomer::class);
    }

    // /**
    //  * @return TrustedCustomer[] Returns an array of TrustedCustomer objects
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
    public function findOneBySomeField($value): ?TrustedCustomer
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
