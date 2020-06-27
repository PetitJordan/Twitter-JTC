<?php

namespace App\Repository\Keyword;

use App\Entity\Keyword\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Request|null find($id, $lockMode = null, $lockVersion = null)
 * @method Request|null findOneBy(array $criteria, array $orderBy = null)
 * @method Request[]    findAll()
 * @method Request[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Request::class);
    }

    // /**
    //  * @return Request[] Returns an array of Request objects
    //  */


    /*
    public function findOneBySomeField($value): ?Request
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findEntry($trendName)
    {

        $qb = $this->createQueryBuilder('r')
            ->where('r.name = :trendName')
            ->setParameter('trendName', $trendName)
            ->orderBy('r.id', 'ASC');

        $query = $qb->getQuery()->getResult();
        return $query;
//        $conn = $this->getEntityManager()->getConnection();
//
//        $sql = 'SELECT * FROM request r where r.name = :trendName order by r.id desc limit 1';
//        $stmt = $conn->prepare($sql);
//        $stmt->execute(['trendName' => $trendName]);
//      dump($stmt->fetch());die;
//
//
//        // returns an array of Request objects
//        return $stmt->fetch();

    }
}
