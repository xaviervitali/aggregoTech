<?php

namespace App\Repository;

use App\Entity\FileUpload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FileUpload|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileUpload|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileUpload[]    findAll()
 * @method FileUpload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileUploadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileUpload::class);
    }

    // /**
    //  * @return FileUpload[] Returns an array of FileUpload objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileUpload
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
