<?php

namespace App\Repository;

use App\Entity\MealMoment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MealMoment|null find($id, $lockMode = null, $lockVersion = null)
 * @method MealMoment|null findOneBy(array $criteria, array $orderBy = null)
 * @method MealMoment[]    findAll()
 * @method MealMoment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealMomentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MealMoment::class);
    }

    // /**
    //  * @return MealMoment[] Returns an array of MealMoment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MealMoment
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
