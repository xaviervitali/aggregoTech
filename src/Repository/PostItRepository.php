<?php

namespace App\Repository;

use App\Entity\PostIt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostIt>
 *
 * @method PostIt|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostIt|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostIt[]    findAll()
 * @method PostIt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostItRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostIt::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PostIt $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PostIt $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PostIt[] Returns an array of PostIt objects
    //  */

    public function getUserRemembers($user, $field = "remember")
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.employee = :val AND p.category = :field')
            ->setParameter('val', $user)
            ->setParameter('field', $field)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?PostIt
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
