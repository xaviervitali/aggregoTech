<?php

namespace App\Repository;

use App\Entity\CollaborationChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollaborationChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollaborationChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollaborationChoice[]    findAll()
 * @method CollaborationChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaborationChoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollaborationChoice::class);
    }

    // /**
    //  * @return CollaborationChoice[] Returns an array of CollaborationChoice objects
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
    public function findOneBySomeField($value): ?CollaborationChoice
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
