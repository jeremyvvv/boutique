<?php

namespace App\Controller;

use App\Entity\Contenir;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ContenirRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panier")
 */

class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index")
     */

    public function index(EntityManagerInterface $manager, SessionInterface $session, ContenirRepository $contenirRepository): Response
    {
        $lesPanier = $manager->getRepository(Panier::class)->findAll();

        if (count($lesPanier) == 0) {
            $lePanier = new Panier();
            $date = date("Y/m/d");
            $lePanier->setDateCreation($date);


            $lePanier->setMontantTotal(0);
            $manager->persist($lePanier);
            $manager->flush();

            $montant_total = 0;
            $lesProduits = array();

        } else {
            $lePanier = $lesPanier[0];
            $dateCreation = $lePanier->getDateCreation();
            $montant_total = $lePanier->getMontantTotal();

            $lesProduits = $manager->getRepository(Contenir::class)->findAll();
        }

        $session->set("panierId", $lePanier->getId());

        return $this->render('panier/index.html.twig',[
            'contenirs' => $contenirRepository->findAll(),
            'controller_name' => 'PanierController',
            'panier' => $lePanier,
            'date_creation' => $dateCreation,
            'montant_total' =>$montant_total,
            'les_produits'=>$lesProduits
        ]);
    }

    /**
     * @Route("/add/{id}", name="panier_add")
     */
    public function add(EntityManagerInterface $manager,Produit $produit,SessionInterface $session): RedirectResponse
    {
        //$session->clear();

        $produits = $session->get('les_produits',array());
        $nbp = count($produits);
        if(!isset($produits[$produit->getId()])){
            $produits[ $produit->getId()]["objProduit"]=$produit;
            $produits[ $produit->getId()]["quantite"]=1;
        } else {
            $produits[ $produit->getId()]["quantite"]++;
        }
        $session->set('total_produit', $session->get('total_produit')+1);
        $session->set('les_produits', $produits);


        $lesPaniers = $manager->getRepository(Panier::class)->findAll();

        if (count($lesPaniers)==0){
            //je créé le panier
            $panier = new Panier();
            $panier->setMontantTotal(0);
            $panier->setDateCreation(date("Y/m/d"));

            $manager->persist($panier);
            $manager->flush();
        }
        else{
            //je récupère l'id du premier panier
            $panier = $lesPaniers[0];
        }
        $session->set('panier', $panier);

        $contenir = new Contenir();
        $contenir->setIdPanier($panier);
        $contenir->setIdProduit($produit);
        $contenir->setQuantite($produits[$produit->getId()]["quantite"]);
        $panier->setMontantTotal($panier->getMontantTotal() + $produit->getTarif());

        $manager->persist($panier);
        $manager->persist($contenir);
        $manager->flush();

        return $this->redirectToRoute('produit_index');
    }

    /**
     * @Route("/remove", name="panier_remove")
     */
    public function remove(EntityManagerInterface $manager, SessionInterface $session): RedirectResponse
    {
        $lesPaniers = $manager->getRepository(Panier::class)->findAll();
        if (count($lesPaniers)==0){
            //je créé le panier
            $panier = new Panier();
            $panier->setMontantTotal(0);
            $panier->setDateCreation(date("Y/m/d"));

            $manager->persist($panier);
            $manager->flush();
        }
        else{
            //je récupère l'id du premier panier
            $panier = $lesPaniers[0];
        }
        $session->set('panier', $panier);
        $session->set('total_produit', 0);

        $panier = $manager->getRepository(Panier::class)->find($session->get('panier'));
        $panier->setMontantTotal(0);
        $contenir = $manager->getRepository(Contenir::class)->find($session->get('panier'));
        $session->clear();


        $manager->flush();

        return $this->redirectToRoute('panier_index');
    }
}
