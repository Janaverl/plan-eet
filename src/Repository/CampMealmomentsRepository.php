<?php

namespace App\Repository;

use App\Entity\CampMealmoments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CampMealmoments|null find($id, $lockMode = null, $lockVersion = null)
 * @method CampMealmoments|null findOneBy(array $criteria, array $orderBy = null)
 * @method CampMealmoments[]    findAll()
 * @method CampMealmoments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampMealmomentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampMealmoments::class);
    }

    // /**
    //  * Undocumented function
    //  *
    //  * @param object $entityManager
    //  * @param object $camp
    //  * @param string $mealmomentname
    //  * @return array
    //  */
    // public function findOneByCampAndMealmomentname(object $entityManager, object $camp, string $mealmomentname): array
    // {
    //     $mealmoment = $entityManager->getRepository('App:Mealmoment')
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
    //  * @return CampMealmoments[] Returns an array of CampMealmoments objects
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
public function findOneBySomeField($value): ?CampMealmoments
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
