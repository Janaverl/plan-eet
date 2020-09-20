<?php

namespace App\Repository;

use App\Entity\Camp;
use App\Entity\Ingredient;
use App\Entity\Mealmoment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
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

    public function findArrayByCampmeal(Camp $camp, Mealmoment $mealmoment, int $campdaycount)
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
            ->setParameter('id', $camp)
            ->setParameter('name', $mealmoment)
            ->setParameter('count', $campdaycount);

        return $query->getResult();

    }

    public function findArrayByCamp(Camp $camp)
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
            ->setParameter('id', $camp);

        return $query->getResult();

    }
}
