<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Util\ClassNameValue;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'products')]
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll(); 
        return $this->render('product/index.html.twig', [
            'products'=> $products
        ]);
    }

    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug)
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(array('slug' => $slug));

        if (!$product) {
            return $this->redirectToRoute(route: 'products');
        }
        return $this->render('product/show.html.twig', [
            'product'=> $product
        ]);
    }
}
