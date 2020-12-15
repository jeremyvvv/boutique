<?php

namespace App\Repository;

use App\Entity\Contenir;
use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method Contenir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contenir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contenir[]    findAll()
 * @method Contenir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContenirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contenir::class);
    }

    /**
     * ce que vosu voulez
     * @param SessionInterface $session
     */
public function deleteTuples(SessionInterface $session){
    $queryBuilder = $this->createQueryBuilder('delete');
    $queryBuilder->delete(Contenir::class, 'c')
        ->where('c.id_panier = :id')
        ->setParameter('id', $session->get('panierId') );

    $query = $queryBuilder->getQuery();

    $query->execute();

}

   // public function deleteOneTuples(SessionInterface $session, Contenir $content){
   //     $queryBuilder = $this->createQueryBuilder('delete');
   //     $queryBuilder->update(Contenir::class, 'c')
   //         ->set('c.quantite', ':qte')
//            ->setParameter('qte', $content->getQuantite() - 1)
   //         ->setParameter('id', $session->get('panierId'))
    //        ->setParameter('id2', $session->get('produit'));

    //    $query = $queryBuilder->getQuery();

    //    $query->execute();

  //  }
    // /**
    //  * @return Contenir[] Returns an array of Contenir objects
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
    public function findOneBySomeField($value): ?Contenir
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
