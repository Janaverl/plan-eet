<?php

namespace App\Repository;

use App\Entity\Campday;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Campday|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campday|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campday[]    findAll()
 * @method Campday[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampdayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campday::class);
    }

    // /**
    //  * @return Campday[] Returns an array of Campday objects
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
    public function findOneBySomeField($value): ?Campday
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