<?php

namespace App\Repository;

use App\Entity\StatementComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatementComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatementComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatementComment[]    findAll()
 * @method StatementComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatementCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatementComment::class);
    }

    // /**
    //  * @return StatementComment[] Returns an array of StatementComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatementComment
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
