<?php

namespace App\Repository;

use App\Entity\CampMealMoments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CampMealMoments|null find($id, $lockMode = null, $lockVersion = null)
 * @method CampMealMoments|null findOneBy(array $criteria, array $orderBy = null)
 * @method CampMealMoments[]    findAll()
 * @method CampMealMoments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampMealMomentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampMealMoments::class);
    }

    // /**
    //  * Undocumented function
    //  *
    //  * @param object $entityManager
    //  * @param object $camp
    //  * @param string $mealmomentname
    //  * @return array
    //  */
    // public function findOneByCampAndMealMomentname(object $entityManager, object $camp, string $mealmomentname): array
    // {
    //     $mealmoment = $entityManager->getRepository('App:MealMoment')
    //         ->findOneBy(['name' => $mealmomentname]);

    //     return $this->createQueryBuilder('this_campmealmoment')
    //         ->andWhere('this_campmealmoment.camp = :camp')
    //         ->setParameter('camp', $camp)
    //         ->andWhere('this_campmealmoment.mealmoment = :val')
    //         ->setParameter('val', $mealmoment)
    //         ->getQuery()
    //         ->execute();
    // }

    // /**
    //  * @return CampMealMoments[] Returns an array of CampMealMoments objects
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
public function findOneBySomeField($value): ?CampMealMoments
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
