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

    // public function findIngrByCampmeal()
    // {
    //     $entityManager = $this->getEntityManager();

    //     $rsm = new ResultSetMapping();

    //     $rsm->addScalarResult('c_name', 'c_name')
    //         ->addScalarResult('r_name', 'r_name')
    //         ->addScalarResult('quantity', 'quantity')
    //         ->addScalarResult('u_name', 'u_name')
    //         ->addScalarResult('ingredient', 'ingredient')
    //         ->addScalarResult('r_name', 'r_name');

    //     $sql =
    //         'SELECT
    //             campmeal.name AS c_name,
    //             recipes.name AS r_name,
    //             ROUND((recipe_ingredients.quantity*(SELECT nr_of_participants FROM camp WHERE camp.id = :id)), 3) AS quantity,
    //             unit.name AS u_name,
    //             ingredient.name AS ingredient,
    //             rayon.name as r_name

    //         FROM campmeal

    //         INNER JOIN mealcourse ON campmeal.id = mealcourse.campmeal_id
    //         INNER JOIN recipes ON mealcourse.recipe_id = recipes.id
    //         INNER JOIN recipe_ingredients ON recipes.id = recipe_ingredients.recipe_id
    //         INNER JOIN ingredient ON recipe_ingredients.ingredient_id = ingredient.id
    //         INNER JOIN unit ON ingredient.unit_id = unit.id
    //         INNER JOIN rayon ON ingredient.rayon_id = rayon.id

    //         WHERE campmeal.id IN
    //             (SELECT campmeal.id FROM campmeal WHERE camp_mealmoment_id IN
    //                 (SELECT camp_mealmoments.id FROM camp_mealmoments
    //                     WHERE camp_mealmoments.camp_id = :id
    //                     AND camp_mealmoments.mealmoment_id =
    //                         (SELECT mealmoment.id FROM mealmoment WHERE mealmoment.name = :name)
    //                 )
    //             )
    //         AND campday_id IN
    //             (SELECT campday.id FROM campday WHERE campday.campdaycount = :count)

    //         ORDER BY rayon.name ASC';

    //     $query = $entityManager->createNativeQuery($sql, $rsm);

    //     $query
    //         ->setParameter('id', 38)
    //         ->setParameter('name', "middagmaal")
    //         ->setParameter('count', 0);
    //     return $query->getResult();

    // }

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
