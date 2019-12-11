<?php

namespace App\Repository;

use App\Entity\RecipeType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RecipeType|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeType|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeType[]    findAll()
 * @method RecipeType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeType::class);
    }

    // /**
    //  * @return RecipeType[] Returns an array of RecipeType objects
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
    public function findOneBySomeField($value): ?RecipeType
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
