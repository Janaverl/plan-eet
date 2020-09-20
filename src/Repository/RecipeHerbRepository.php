<?php

namespace App\Repository;

use App\Entity\RecipeHerb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecipeHerb|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeHerb|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeHerb[]    findAll()
 * @method RecipeHerb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeHerbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeHerb::class);
    }

    // /**
    //  * @return RecipeHerb[] Returns an array of RecipeHerb objects
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
    public function findOneBySomeField($value): ?RecipeHerb
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
