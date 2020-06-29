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

    // Enregistre le trend avec son volume
    public function createTrend($trendName, $trendVolume)
    {

        $trend = new Request();
        $trend->setName($trendName);
        $trend->setNbTweet($trendVolume);

        $this->_em->persist($trend);

        $this->_em->flush();

        return;
    }

    // Récupère toutes les entrées d'un trend
    public function findEntry($trendName)
    {

        $qb = $this->createQueryBuilder('r')
            ->where('r.name = :trendName')
            ->setParameter('trendName', $trendName)
            ->orderBy('r.id', 'ASC');

        $query = $qb->getQuery()->getResult();
        return $query;
    }

    // Récupère les dernieres entrées des trends du jour
    public function findCurrentTrends()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'Select r.name, r.nb_tweet 
                from api_twitter.request r
                inner join 
                (
                    Select max(r2.id) as LatestDate , r2.name
                    from api_twitter.request r2
                    Group by r2.name
                ) as SubMax 
                on r.id = SubMax.LatestDate
                and r.name = SubMax.name
                where created_at >= CURDATE() and
                  created_at < CURDATE() +1 ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of Request objects
        return $stmt->fetchAll();
    }

}
