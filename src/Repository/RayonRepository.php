<?php

namespace App\Repository;

use App\Entity\Rayon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Rayon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rayon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rayon[]    findAll()
 * @method Rayon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RayonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rayon::class);
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
