<?php

namespace App\Repository;

use App\Entity\Correspondre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Correspondre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Correspondre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Correspondre[]    findAll()
 * @method Correspondre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorrespondreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Correspondre::class);
    }

    // /**
    //  * @return Correspondre[] Returns an array of Correspondre objects
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
    public function findOneBySomeField($value): ?Correspondre
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
