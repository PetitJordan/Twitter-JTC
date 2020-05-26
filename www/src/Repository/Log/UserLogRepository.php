<?php

namespace App\Repository\Log;

use App\Entity\Log\UserLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLog[]    findAll()
 * @method UserLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserLog::class);
    }

    public function pagerfanta(array $params = null)
    {
        $idUser = $params['idUser'] ?? null;
        $dateStart = $params['dateStart'] ?? null;
        $dateEnd = $params['dateEnd'] ?? null;

        $qb = $this->createQueryBuilder('ul');

        if ($idUser !== null) {
            $qb->andWhere('ul.idUser = :idUser')
                ->setParameter('idUser', $idUser);
        }

        if ($dateStart !== null) {
            $qb->andWhere('ul.dateCreate >= :dateStart')
                ->setParameter('dateStart', $dateStart);
        }

        if ($dateEnd !== null) {
            $qb->andWhere('ul.dateCreate <= :dateEnd')
                ->setParameter('dateEnd', $dateEnd);
        }

        $qb->orderBy('ul.timeCreate', 'DESC');

        return $qb;
    }
    // /**
    //  * @return UserLog[] Returns an array of UserLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserLog
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
