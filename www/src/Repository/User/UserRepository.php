<?php

namespace App\Repository\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findCustom(array $params = null)
    {
        $role = $params['role'] ?? null;
        $notRole = $params['notRole'] ?? null;
        $emailLike = $params['emailLike'] ?? null;

        $qb = $this->createQueryBuilder('u');

        if ($role !== null) {
            $qb->andWhere('u.roles LIKE :role')
                ->setParameter('role', '%'.$role.'%');
        }

        if ($notRole !== null) {
            $qb->andWhere('u.roles NOT LIKE :role')
                ->setParameter('role', '%'.$notRole.'%');
        }

        if ($emailLike !== null) {
            $qb->andWhere('u.email LIKE :emailLike')
                ->setParameter('emailLike', $emailLike.'%');
        }

        $results = $qb->getQuery()->getResult();

        return $results;
    }
    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
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
