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
}
