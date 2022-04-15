<?php

namespace App\Repository;

use App\Entity\AddressBookContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AddressBookContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddressBookContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddressBookContact[]    findAll()
 * @method AddressBookContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressBookContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddressBookContact::class);
    }

    // /**
    //  * @return AddressBookContact[] Returns an array of AddressBookContact objects
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
    public function findOneBySomeField($value): ?AddressBookContact
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
