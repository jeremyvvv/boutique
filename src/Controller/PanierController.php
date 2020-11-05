<?php

namespace App\Controller;

use App\Entity\Contenir;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function index(EntityManagerInterface $manager): Response
    {
        $lePanier = $manager->getRepository(Panier::class)->findAll();

        if (count($lePanier) == 0) {
            $lePanier = new Panier();
            $dateCreation = "2020/11/05";

            $date = date("Y/m/d");
            $result = $date;
            $lePanier->setDateCreation($date);


            $lePanier->setMontantTotal(0);
            $manager->persist($lePanier);
            $manager->flush();

            $montant_total = 0;
            $lesProduits = array();

        } else {
            $lePanier=$lePanier[0];
            $dateCreation = $lePanier->getDateCreation();
            $montant_total = $lePanier->getMontantTotal();

            $lesProduits = $manager->getRepository(Contenir::class)->findAll();
        }

        return $this->render('panier/index.html.twig',[
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
        if(!isset($produits[$produit->getId()])){

            $produits[ $produit->getId()]["objProduit"]=$produit;
            $produits[ $produit->getId()]["quantite"]=1;
        } else {
            $produits[ $produit->getId()]["quantite"]++;
        }
        $session->set('les_produits', $produits);

        return $this->redirectToRoute('produit_index');

    }
}
