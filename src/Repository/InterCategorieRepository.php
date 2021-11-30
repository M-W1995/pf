<?php

namespace App\Repository;

use App\Entity\InterCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InterCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterCategorie[]    findAll()
 * @method InterCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterCategorie::class);
    }

    // /**
    //  * @return InterCategorie[] Returns an array of InterCategorie objects
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
    public function findOneBySomeField($value): ?InterCategorie
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
