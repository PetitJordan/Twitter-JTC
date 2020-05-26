<?php

namespace App\Repository\Actuality;

use App\Entity\Actuality\Actuality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Actuality|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actuality|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actuality[]    findAll()
 * @method Actuality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actuality::class);
    }


    /**
     * @param array|null $params
     * @return Actuality[]
     * @throws \Exception
     */
    public function findCustom(array $params = null)
    {
        $published = $params['published'] ?? null;
        $orderBy = $params['orderBy'] ?? null;
        $limitMax = $params['limitMax'] ?? null;
        $pined = $params['pined'] ?? null;

        $qb = $this->createQueryBuilder('a');

        if ($published) {
            // On n'affiche pas plus d'un mois à l'avance
            $today = new \DateTime(date('Y-m-d'));
            $qb->andWhere('
                (a.dateStart <= :today AND a.dateEnd >= :today)
                OR 
                (a.dateStart IS NULL and a.dateEnd IS NULL)
                OR
                (a.dateStart <= :today AND a.dateEnd IS NULL)
                OR
                (a.dateStart IS NULL AND a.dateEnd >= :today)                
                ')
                ->setParameter('today', $today->format('Y-m-d'))
                ->andWhere('a.active = :active')
                ->setParameter('active', 1);
        }

        if ($orderBy) {
            $qb->orderBy($orderBy['sort'], $orderBy['order']);
        }

        if ($limitMax) {
            $qb->setMaxResults($limitMax);
        }
        if ($pined) {
            $qb->andWhere('
                (a.pin = :pined)
                ')
                ->setParameter('pined', $pined);
        }

        return $qb->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Actuality[] Returns an array of Actuality objects
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
    public function findOneBySomeField($value): ?Actuality
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
