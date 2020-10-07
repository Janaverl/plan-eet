<?php

namespace App\Repository;

use App\Entity\Camp;
use App\Entity\Rayon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Rayon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rayon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rayon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RayonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rayon::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    public function findByCamp(Camp $camp)
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();

        $rsm
            ->addScalarResult('rayon_id', 'id')
            ->addScalarResult('rayon_name', 'name');

        $sql =
            'SELECT
                rayon.name as rayon_name,
                rayon.id as rayon_id

            FROM rayon

            where id IN(
                SELECT ingredient.rayon_id FROM ingredient WHERE id IN(
                    SELECT recipe_ingredients.ingredient_id FROM recipe_ingredients WHERE recipe_id IN(
                        SELECT mealcourse.recipe_id FROM mealcourse WHERE campmeal_id IN(
                            SELECT campmeal.id FROM campmeal WHERE camp_mealmoment_id IN(
                                SELECT camp_mealmoments.id FROM camp_mealmoments
                                        WHERE camp_mealmoments.camp_id = :id 
                            )
                        )
                    )
                )
            )

            GROUP BY rayon.id
            ORDER BY rayon.name ASC';

        $query = $entityManager->createNativeQuery($sql, $rsm);

        $query
            ->setParameter('id', $camp);

        return $query->getResult();
    }

    // /**
    //  * @return Rayon[] Returns an array of Rayon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rayon
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
