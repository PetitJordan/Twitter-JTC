<?php

namespace App\Repository\User;

use App\Entity\User\Optin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Optin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Optin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Optin[]    findAll()
 * @method Optin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptinRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Optin::class);
    }

    // /**
    //  * @return Optin[] Returns an array of Optin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Optin
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
