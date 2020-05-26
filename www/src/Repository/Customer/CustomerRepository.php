<?php

namespace App\Repository\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\Expertise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function findAllByExpertise($idExpertise)
    {
        Return $this->createQueryBuilder('c')
            ->addSelect('e.name')
            ->leftJoin('c.expertise', 'e')
            ->addSelect('e')
            ->andWhere('e.id IN(:val)')
            ->andWhere('c.active = true')
            ->groupBy('e.name')
            ->setParameter('val', $idExpertise)
            ->getQuery()
            ->getSQL();
    }

    /*
    public function findOneBySomeField($value): ?Customer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}