<?php

namespace App\Repository;

use App\Entity\Attendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Attendance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attendance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attendance[]    findAll()
 * @method Attendance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attendance::class);
    }

    // /**
    //  * @return Attendance[] Returns an array of Attendance objects
    //  */

    public function findByExampleField($month, $user)
    {
        $year = date_format($month, "Y");
        $monthNumber = date_format($month, "m");
        $number = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
        $date = "$year/$monthNumber/$number";
        $query = ($this->createQueryBuilder('a')
            ->andWhere('a.user = :user')
            ->setParameter('user', $user)
            ->andWhere('a.createdAt >= :month')
            ->setParameter('month', $month)
            ->andWhere('a.createdAt <= :date  ')
            ->setParameter('date', $date)

            // ->orderBy('a.id', 'ASC')
            ->getQuery());
        return $query
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Attendance
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
