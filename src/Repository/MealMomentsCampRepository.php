<?php

namespace App\Repository;

use App\Entity\MealMomentsCamp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MealMomentsCamp|null find($id, $lockMode = null, $lockVersion = null)
 * @method MealMomentsCamp|null findOneBy(array $criteria, array $orderBy = null)
 * @method MealMomentsCamp[]    findAll()
 * @method MealMomentsCamp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealMomentsCampRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MealMomentsCamp::class);
    }

    // /**
    //  * @return MealMomentsCamp[] Returns an array of MealMomentsCamp objects
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
    public function findOneBySomeField($value): ?MealMomentsCamp
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
