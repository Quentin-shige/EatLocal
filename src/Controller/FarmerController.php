<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FarmerController extends AbstractController
{
    #[Route('/farmer', name: 'farmer')]
    public function index(): Response
    {
        return $this->render('farmer/index.html.twig', [
            'controller_name' => 'FarmerController',
        ]);
    }
}
