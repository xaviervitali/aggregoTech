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



    public function findAttendanceForDateAndUser($month, $user)

    {

        $requetedDate = (date_format($month, "Y-m"));
        $query = ($this->createQueryBuilder('a')

            ->andWhere('a.user = :user')
            ->setParameter('user', $user)
            ->andWhere('a.createdAt LIKE  :date')
            ->setParameter('date', $requetedDate . "%")
            ->getQuery());

        return $query

            ->getResult();
    }
}
