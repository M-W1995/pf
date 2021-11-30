<?php

namespace App\Repository;

use App\Entity\Inter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inter[]    findAll()
 * @method Inter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inter::class);
    }

    // /**
    //  * @return Inter[] Returns an array of Inter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Inter
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
