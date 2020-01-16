<?php

namespace App\Repository;

use App\Entity\Campmeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Campmeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campmeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campmeal[]    findAll()
 * @method Campmeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampmealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campmeal::class);
    }

    // /**
    //  * @return Campmeal[] Returns an array of Campmeal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Campmeal
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
