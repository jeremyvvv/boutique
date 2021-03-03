<?php

namespace App\Controller;

use App\Entity\Correspondre;
use App\Form\CorrespondreType;
use App\Repository\CorrespondreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/correspondre")
 */
class CorrespondreController extends AbstractController
{
    /**
     * @Route("/", name="correspondre_index", methods={"GET"})
     */
    public function index(CorrespondreRepository $correspondreRepository): Response
    {
        return $this->render('correspondre/index.html.twig', [
            'correspondres' => $correspondreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="correspondre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $correspondre = new Correspondre();
        $form = $this->createForm(CorrespondreType::class, $correspondre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($correspondre);
            $entityManager->flush();

            return $this->redirectToRoute('correspondre_index');
        }

        return $this->render('correspondre/new.html.twig', [
            'correspondre' => $correspondre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="correspondre_show", methods={"GET"})
     */
    public function show(Correspondre $correspondre): Response
    {
        return $this->render('correspondre/show.html.twig', [
            'correspondre' => $correspondre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="correspondre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Correspondre $correspondre): Response
    {
        $form = $this->createForm(CorrespondreType::class, $correspondre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('correspondre_index');
        }

        return $this->render('correspondre/edit.html.twig', [
            'correspondre' => $correspondre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="correspondre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Correspondre $correspondre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$correspondre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($correspondre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('correspondre_index');
    }
}
