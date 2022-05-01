<?php

namespace App\Repository;

use App\Entity\AppreciationCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AppreciationCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppreciationCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppreciationCategory[]    findAll()
 * @method AppreciationCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppreciationCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppreciationCategory::class);
    }

    // /**
    //  * @return AppreciationCategory[] Returns an array of AppreciationCategory objects
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
    public function findOneBySomeField($value): ?AppreciationCategory
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
