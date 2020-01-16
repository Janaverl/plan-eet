<?php

namespace App\Repository;

use App\Entity\Mealcourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Mealcourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mealcourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mealcourse[]    findAll()
 * @method Mealcourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealcourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mealcourse::class);
    }

    // /**
    //  * @return Mealcourse[] Returns an array of Mealcourse objects
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
    public function findOneBySomeField($value): ?Mealcourse
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
