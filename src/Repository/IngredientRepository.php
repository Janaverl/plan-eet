<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    public function findArrayByCampmeal($campid, $mealmomentname, $campdaycount)
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();

        $rsm
            ->addScalarResult('ingredient', 'name')
            ->addScalarResult('quant', 'quantity')
            ->addScalarResult('u_name', 'u_name')
            ->addScalarResult('r_name', 'r_name');

        $sql =
            'SELECT
                DISTINCT ingredient.name AS ingredient,
                SUM(ROUND((recipe_ingredients.quantity*(SELECT nr_of_participants FROM camp WHERE camp.id = :id)), 3)) AS quant,
                unit.name AS u_name,
                rayon.name as r_name

            FROM campmeal

            INNER JOIN mealcourse ON campmeal.id = mealcourse.campmeal_id
            INNER JOIN recipes ON mealcourse.recipe_id = recipes.id
            INNER JOIN recipe_ingredients ON recipes.id = recipe_ingredients.recipe_id
            INNER JOIN ingredient ON recipe_ingredients.ingredient_id = ingredient.id
            INNER JOIN unit ON ingredient.unit_id = unit.id
            INNER JOIN rayon ON ingredient.rayon_id = rayon.id

            WHERE campmeal.id IN
                (SELECT campmeal.id FROM campmeal WHERE camp_mealmoment_id IN
                    (SELECT camp_mealmoments.id FROM camp_mealmoments
                        WHERE camp_mealmoments.camp_id = :id
                        AND camp_mealmoments.mealmoment_id =
                            (SELECT mealmoment.id FROM mealmoment WHERE mealmoment.name = :name)
                    )
                )
            AND campday_id IN
                (SELECT campday.id FROM campday WHERE campday.campdaycount = :count)

            GROUP BY ingredient
            ORDER BY rayon.name ASC';

        $query = $entityManager->createNativeQuery($sql, $rsm);

        $query
            ->setParameter('id', $campid)
            ->setParameter('name', $mealmomentname)
            ->setParameter('count', $campdaycount);

        return $query->getResult();

    }

    public function findArrayByCamp($campid)
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();

        $rsm
            ->addScalarResult('ingredient', 'name')
            ->addScalarResult('quant', 'quantity')
            ->addScalarResult('u_name', 'u_name')
            ->addScalarResult('r_name', 'r_name');

        $sql =
            'SELECT
                DISTINCT ingredient.name AS ingredient,
                SUM(ROUND((recipe_ingredients.quantity*(SELECT nr_of_participants FROM camp WHERE camp.id = :id)), 3)) AS quant,
                unit.name AS u_name,
                rayon.name as r_name

            FROM campmeal

            INNER JOIN mealcourse ON campmeal.id = mealcourse.campmeal_id
            INNER JOIN recipes ON mealcourse.recipe_id = recipes.id
            INNER JOIN recipe_ingredients ON recipes.id = recipe_ingredients.recipe_id
            INNER JOIN ingredient ON recipe_ingredients.ingredient_id = ingredient.id
            INNER JOIN unit ON ingredient.unit_id = unit.id
            INNER JOIN rayon ON ingredient.rayon_id = rayon.id

            WHERE campmeal.id IN
                (SELECT campmeal.id FROM campmeal WHERE camp_mealmoment_id IN
                    (SELECT camp_mealmoments.id FROM camp_mealmoments
                        WHERE camp_mealmoments.camp_id = :id
                    )
                )

            GROUP BY ingredient
            ORDER BY rayon.name ASC';

        $query = $entityManager->createNativeQuery($sql, $rsm);

        $query
            ->setParameter('id', $campid);

        return $query->getResult();

    }

    // public function findByCampmealSec($recipe)
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT
    //             ingr_recipe.quantity as quantity,
    //             unit.name as unit_name,
    //             ingredient.name as ingrendient_name,
    //             rayon.name as rayon_name,
    //             recipes.name as recipe_name
    //         FROM App\Entity\Recipes recipes,

    //         INNER JOIN ingredient.recipe ingr_recipe
    //         INNER JOIN ingr_recipe.recipe recipes
    //         INNER JOIN ingredient.unit unit
    //         INNER JOIN ingredient.rayon rayon
    //         WHERE recipes.name = :id
    //         ORDER BY rayon.name'
    //     )
    //         ->setParameter('id', $recipe);

    //     return $query->getResult();
    // }

    // /**
    //  * @return Ingredient[] Returns an array of Ingredient objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('i')
    ->andWhere('i.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('i.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
public function findOneBySomeField($value): ?Ingredient
{
return $this->createQueryBuilder('i')
->andWhere('i.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
 */
}
