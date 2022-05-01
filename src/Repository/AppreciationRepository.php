<?php

namespace App\Repository;

use App\Entity\Appreciation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appreciation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appreciation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appreciation[]    findAll()
 * @method Appreciation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppreciationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appreciation::class);
    }

    // /**
    //  * @return Appreciation[] Returns an array of Appreciation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appreciation
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
