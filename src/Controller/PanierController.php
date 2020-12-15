<?php

namespace App\Controller;

use App\Entity\Contenir;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ContenirRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/panier")
 */

class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index")
     */

    public function index(EntityManagerInterface $manager, SessionInterface $session, ContenirRepository $contenirRepository, ProduitRepository $produitRepository): Response
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
            'produits' => $produitRepository->findAll(),
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
     * Methode ajoutant un objet au panier et redirige vers la page du meme produit
     */
    public function add(EntityManagerInterface $manager,Produit $produit,SessionInterface $session): RedirectResponse
    {
        //$session->clear();
        $contenir = new Contenir();
        $produits = $session->get('les_produits',array());
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
        //si le produit voulu n'est pas dans le panier, on le rajoute
        if(!isset($produits[$produit->getId()])){
            $produits[ $produit->getId()]["objProduit"]=$produit;
            $produits[ $produit->getId()]["quantite"]=1;

            $contenir->setIdPanier($panier);
            $contenir->setIdProduit($produit);
            $contenir->setQuantite(1);
            $manager->persist($contenir);

        } else {
            //si le produit voulu est déjà dans le panier, on y ajoute 1 à la quantité

            $qte = $produits[$produit->getId()]["quantite"];
            $qte++;
            $produits[ $produit->getId()]["quantite"] = $qte;
            $contenir = $manager->getRepository(Contenir::class)->findAll();
            foreach ($contenir as $key => $unProduit){
                if($unProduit->getIdProduit()->getId() == $produit->getId()){
                    $contenir[$key]->setQuantite($contenir[$key]->getQuantite()+1);
                }
            }
            $manager->flush();

        }


        $panier->setMontantTotal($panier->getMontantTotal() + $produit->getTarif());
        $manager->flush();

        $session->set('total_produit', $session->get('total_produit')+1);
        $session->set('les_produits', $produits);

        $session->set('panier', $panier);


        return $this->redirectToRoute('produit_show', ['id'=>$produit->getId()]);

    }

    /**
     * @Route("/add2/{id}", name="panier_add2")
     * Methode ajoutant un objet au panier et redirige vers la page panier
     */
    public function add2(EntityManagerInterface $manager,Produit $produit,SessionInterface $session): RedirectResponse
    {
        //$session->clear();
        $contenir = new Contenir();
        $produits = $session->get('les_produits',array());
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
        //si le produit voulu n'est pas dans le panier, on le rajoute
        if(!isset($produits[$produit->getId()])){
            $produits[ $produit->getId()]["objProduit"]=$produit;
            $produits[ $produit->getId()]["quantite"]=1;

            $contenir->setIdPanier($panier);
            $contenir->setIdProduit($produit);
            $contenir->setQuantite(1);
            $manager->persist($contenir);

        } else {
            //si le produit voulu est déjà dans le panier, on y ajoute 1 à la quantité

            $qte = $produits[$produit->getId()]["quantite"];
            $qte++;
            $produits[ $produit->getId()]["quantite"] = $qte;
            $contenir = $manager->getRepository(Contenir::class)->findAll();
            foreach ($contenir as $key => $unProduit){
                if($unProduit->getIdProduit()->getId() == $produit->getId()){
                    $contenir[$key]->setQuantite($contenir[$key]->getQuantite()+1);
                }
            }
            $manager->flush();

        }


        $panier->setMontantTotal($panier->getMontantTotal() + $produit->getTarif());
        $manager->flush();

        $session->set('total_produit', $session->get('total_produit')+1);
        $session->set('les_produits', $produits);

        $session->set('panier', $panier);


        return $this->redirectToRoute('panier_index');

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
        $contenir = $manager->getRepository(Contenir::class);//->find($session->get('panier'));
        $contenir->deleteTuples($session);
        $session->clear();


        $manager->flush();
        return $this->redirectToRoute('panier_index');
    }


    /**
     * @Route("/{id}", name="panier_removeone", methods={"DELETE"})
     */
    public function removeOne(EntityManagerInterface $manager, SessionInterface $session, Contenir $contenir, Request $request): RedirectResponse
    {

        $lesPaniers = $manager->getRepository(Panier::class)->findAll();
        if ($this->isCsrfTokenValid('delete'.$contenir->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contenir);
            $entityManager->flush();
        }

        //je récupère l'id du premier panier
        $panier = $lesPaniers[0];

        $session->set('panier', $panier);
        $session->set('total_produit', 0);

        $panier = $manager->getRepository(Panier::class)->find($session->get('panier'));
        $panier->setMontantTotal(0);
        $session->clear();

        $manager->flush();
        return $this->redirectToRoute('panier_index');
    }
}
