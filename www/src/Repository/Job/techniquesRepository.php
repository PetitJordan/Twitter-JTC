<?php

namespace App\Repository\Job;

use App\Entity\Job\Techniques;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method techniques|null find($id, $lockMode = null, $lockVersion = null)
 * @method techniques|null findOneBy(array $criteria, array $orderBy = null)
 * @method techniques[]    findAll()
 * @method techniques[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class techniquesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, techniques::class);
    }

    // /**
    //  * @return techniques[] Returns an array of techniques objects
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
    public function findOneBySomeField($value): ?techniques
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
