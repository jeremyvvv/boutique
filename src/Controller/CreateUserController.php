<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserController extends AbstractController
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/create/user", name="create_user")
     */
    public function index(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail("admin@admin.com");
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, 'admin'
        ));
        $user->setRoles(array("ROLE_USER"));

        $manager->persist($user);
        $manager->flush();

        $produits = $manager->getRepository(Produit::class)->findBy(array(), array('id' => 'ASC'), 3);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'produits' => $produits,

        ]);


    }

}
