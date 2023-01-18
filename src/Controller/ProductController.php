<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'app_product')]
    public function index(Request $request): Response
    {
        $search = new Search(); // On initialise notre class
        $form = $this->createForm(SearchType::class, $search); // qu'on passe la méthode createForm

        $form->handleRequest($request); // On écoute le formulaire
        
        if ($form->isSubmitted() && $form->isValid()) { // on demande si le formulaire est soumis et valide
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search); // on rentre dedans et on envoie une nouvelle fonction qu'on a créer
        } else {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig', [
            "products" => $products,
            "form" => $form->createView()
        ]);
    }

    #[Route('/produit/{name}', name: 'product')]
    public function show($name): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneByName($name);

        if (!$product) {
            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/show.html.twig', [
            "product" => $product
        ]);
    }
}
