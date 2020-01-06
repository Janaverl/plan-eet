<?php

namespace App\Repository;

use App\Entity\Herb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Herb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Herb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Herb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HerbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Herb::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    // /**
    //  * @return Herb[] Returns an array of Herb objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Herb
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
