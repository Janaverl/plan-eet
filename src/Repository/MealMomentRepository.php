<?php

namespace App\Repository;

use App\Entity\Mealmoment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Mealmoment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mealmoment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mealmoment[]    findAll()
 * @method Mealmoment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealMomentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mealmoment::class);
    }

    // /**
    //  * @return Mealmoment[] Returns an array of Mealmoment objects
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
    public function findOneBySomeField($value): ?Mealmoment
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
