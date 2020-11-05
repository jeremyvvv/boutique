<?php

namespace App\Controller;

use App\Entity\Contenir;
use App\Form\ContenirType;
use App\Repository\ContenirRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contenir")
 */
class ContenirController extends AbstractController
{
    /**
     * @Route("/", name="contenir_index", methods={"GET"})
     */
    public function index(ContenirRepository $contenirRepository): Response
    {
        return $this->render('contenir/index.html.twig', [
            'contenirs' => $contenirRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contenir_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contenir = new Contenir();
        $form = $this->createForm(ContenirType::class, $contenir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contenir);
            $entityManager->flush();

            return $this->redirectToRoute('contenir_index');
        }

        return $this->render('contenir/new.html.twig', [
            'contenir' => $contenir,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contenir_show", methods={"GET"})
     */
    public function show(Contenir $contenir): Response
    {
        return $this->render('contenir/show.html.twig', [
            'contenir' => $contenir,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contenir_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contenir $contenir): Response
    {
        $form = $this->createForm(ContenirType::class, $contenir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contenir_index');
        }

        return $this->render('contenir/edit.html.twig', [
            'contenir' => $contenir,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contenir_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contenir $contenir): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contenir->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contenir);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contenir_index');
    }
}
