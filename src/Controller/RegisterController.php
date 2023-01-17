<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    // Gère les opérations de persistance des entités
    private $entityManager;

    // Injection de dépendance de l'entityManager
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/inscription", name: "app_register")]
    public function index(Request $request): Response
    {
        // Création d'un nouvel utilisateur
        $user = new User();

        // Création du formulaire d'inscription en utilisant la classe RegisterType
        $form = $this->createForm(RegisterType::class, $user);

        // Traitement des données du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire
            $user = $form->getData();

            // Persistance de l'utilisateur dans la base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        // Rendu de la vue du formulaire d'inscription
        return $this->render("register/index.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
