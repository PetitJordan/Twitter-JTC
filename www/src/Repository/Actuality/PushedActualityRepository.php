<?php

namespace App\Repository\Actuality;

use App\Entity\Actuality\Actuality;
use App\Entity\Actuality\PushedActuality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PushedActuality|null find($id, $lockMode = null, $lockVersion = null)
 * @method PushedActuality|null findOneBy(array $criteria, array $orderBy = null)
 * @method PushedActuality[]    findAll()
 * @method PushedActuality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PushedActualityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PushedActuality::class);
    }

    /**
     * @param array|null $params
     * @return PushedActualityRepository[]
     * @throws \Exception
     */
    public function findCustom(array $params = null)
    {
        $published = $params['published'] ?? null;
        $orderBy = $params['orderBy'] ?? null;
        $limitMax = $params['limitMax'] ?? null;
        $pined = $params['pined'] ?? null;

        $qb = $this->createQueryBuilder('pa')
        ->leftJoin('pa.Actuality', 'a');

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
//        dd($qb->getQuery()->getSQL());
        return $qb->getQuery()
            ->getResult();
    }


    // /**
    //  * @return PushedActuality[] Returns an array of PushedActuality objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PushedActuality
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function toggleUnique( array $params = null)
    {
        $field = $params['field'] ?? null;
        $id = $params['id'] ?? null;

        $sqlParams = array();

        $conn = $this->getEntityManager()->getConnection();
        $table = $this->getEntityManager()->getClassMetadata(PushedActuality::class)->getTableName();

//        METS 1 DANS L'ID
        $sql = "UPDATE ".$table." SET ".$field." = 1 WHERE id = :id";
        $sqlParams['id'] = $id;

        $stmt = $conn->prepare($sql);
        $stmt->execute($sqlParams);

//        RESTE 0
        $sql = "UPDATE ".$table." SET ".$field." = 0 WHERE id != :id";
        $sqlParams['id'] = $id;


        $stmt = $conn->prepare($sql);
        $stmt->execute($sqlParams);

        return true;
    }
}
