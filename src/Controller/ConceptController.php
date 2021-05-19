<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConceptController extends AbstractController
{
    #[Route('/concept', name: 'concept')]
    public function index(): Response
    {
        return $this->render('concept/index.html.twig', [
            'controller_name' => 'ConceptController',
        ]);
    }
}
