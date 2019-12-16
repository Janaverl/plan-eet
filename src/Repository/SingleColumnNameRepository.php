<?php

namespace App\Repository;

use App\Entity\SingleColumnName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SingleColumnName|null find($id, $lockMode = null, $lockVersion = null)
 * @method SingleColumnName|null findOneBy(array $criteria, array $orderBy = null)
 * @method SingleColumnName[]    findAll()
 * @method SingleColumnName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SingleColumnNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SingleColumnName::class);
    }

    // /**
    //  * @return SingleColumnName[] Returns an array of SingleColumnName objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SingleColumnName
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
