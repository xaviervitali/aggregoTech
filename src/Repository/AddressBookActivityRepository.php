<?php

namespace App\Repository;

use App\Entity\AddressBookActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AddressBookActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddressBookActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddressBookActivity[]    findAll()
 * @method AddressBookActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressBookActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddressBookActivity::class);
    }

    // /**
    //  * @return AddressBookActivity[] Returns an array of AddressBookActivity objects
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
    public function findOneBySomeField($value): ?AddressBookActivity
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
