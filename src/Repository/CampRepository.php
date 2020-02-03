<?php

namespace App\Repository;

use App\Entity\Camp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Camp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Camp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Camp[]    findAll()
 * @method Camp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Camp::class);
    }

    public function findAllCampsByUser($user)
    {
        return $this->createQueryBuilder('all_camps')
            ->andWhere('all_camps.user = :val')
            ->setParameter('val', $user)
            ->orderBy('all_camps.startTime', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllCampsByUserPresent($user)
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('all_camps')
            ->andWhere('all_camps.user = :val')
            ->setParameter('val', $user)
            ->andWhere('all_camps.endTime > :time')
            ->andWhere('all_camps.startTime < :time')
            ->setParameter('time', $now)
            ->orderBy('all_camps.startTime', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function findAllCampsByUserFromNow($user)
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('all_camps')
            ->andWhere('all_camps.user = :val')
            ->setParameter('val', $user)
            ->andWhere('all_camps.endTime > :time')
            ->setParameter('time', $now)
            ->orderBy('all_camps.startTime', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function findAllCampsByUserPast($user)
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('all_camps')
            ->andWhere('all_camps.user = :val')
            ->setParameter('val', $user)
            ->andWhere('all_camps.endTime < :time')
            ->setParameter('time', $now)
            ->orderBy('all_camps.startTime', 'DESC')
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return Camp[] Returns an array of Camp objects
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
public function findOneBySomeField($value): ?Camp
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
