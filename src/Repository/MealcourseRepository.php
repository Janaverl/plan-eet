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

    // public function findCoursesby($campId, $mealname, $count)
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         // 'SELECT camp, campMealmoments, mealmoment, campday
    //         'SELECT camp, campMealmoments, mealmoment, campday
    //         FROM App\Entity\CampMealmoments campMealmoments
    //         INNER JOIN campMealmoments.camp camp
    //         INNER JOIN campMealmoments.mealmoment mealmoment
    //         INNER JOIN camp.campdays campday
    //         WHERE camp.id = :id
    //         AND mealmoment.name = :name
    //         AND campday.campdaycount = :count'
    //     )
    //         ->setParameter('id', $campId)
    //         ->setParameter('name', $mealname)
    //         ->setParameter('count', $count);

    //     return $query->getResult();
    // }

    // public function findOneByIdJoined($recipeId)
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT recipes, recipeIngredients
    //         FROM App\Entity\Recipes recipes
    //         INNER JOIN recipes.recipeIngredients recipeIngredients
    //         WHERE recipes.id = :id'
    //     )->setParameter('id', $recipeId);

    //     return $query->getResult();
    // }

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
