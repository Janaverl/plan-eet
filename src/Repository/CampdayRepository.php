<?php

namespace App\Repository;

use App\Entity\Camp;
use App\Entity\Campday;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Campday|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campday|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campday[]    findAll()
 * @method Campday[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampdayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campday::class);
    }

    public function findDatesByCamp(Camp $camp) : array
    {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping();

        $rsm
            ->addScalarResult('campdaycount', 'campdaycount')
            ->addScalarResult('meal_date', 'date');

        $sql =
            "SELECT
                campday.campdaycount AS campdaycount,
                DATE_FORMAT(DATE_ADD(camp.start_time, INTERVAL (campday.campdaycount) DAY), '%d/%m/%Y') AS meal_date 

            FROM campday

            INNER JOIN camp ON camp.id = campday.camp_id

            WHERE camp.id = :id
            
            ORDER BY campday.campdaycount ASC";

        $query = $entityManager->createNativeQuery($sql, $rsm);

        $query
            ->setParameter('id', $camp);

        return $query->getResult();
    }

    // public function findOneByCampAndCampdaycount(object $entityManager, object $camp, string $campdaycount): array
    // {
    //     return $this->createQueryBuilder('campday')
    //         ->andWhere('campday.camp = :camp')
    //         ->setParameter('camp', $camp)
    //         ->andWhere('campday.campdaycount = :campdaycount')
    //         ->setParameter('campdaycount', $campdaycount)
    //         ->getQuery()
    //         ->execute();
    // }

    // /**
    //  * @return Campday[] Returns an array of Campday objects
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
public function findOneBySomeField($value): ?Campday
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
