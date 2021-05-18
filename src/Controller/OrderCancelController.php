<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/erreur/{stripeSessionId}', name: 'order_cancel')]
    public function index($stripeSessionId)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        // ici on verifie si la commande existe et si lutilisateur est le bon si tout est faux on redirige vers homepage
        if($order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }
        // pas de is_paid car la commande nest pas payee en cas dechec
        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}
