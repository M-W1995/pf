<?php

namespace App\Repository;

use App\Entity\Condoleances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Condoleances|null find($id, $lockMode = null, $lockVersion = null)
 * @method Condoleances|null findOneBy(array $criteria, array $orderBy = null)
 * @method Condoleances[]    findAll()
 * @method Condoleances[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CondoleancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Condoleances::class);
    }

    // /**
    //  * @return Condoleances[] Returns an array of Condoleances objects
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
    public function findOneBySomeField($value): ?Condoleances
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
