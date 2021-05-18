<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Classe\Cart;

class OrderValidateController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/merci/{stripeSessionId}', name: 'order_validate')]
    public function index(Cart $cart, $stripeSessionId)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        // ici on verifie si la commande existe et si lutilisateur est le bon si tout est faux on redirige vers homepage
        if($order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        //modifier is_paid en 1
        if ($order->getIsPaid()) {
            //vider le panier quand lachat est passe
            $cart->remove();
            $order->setIspaid(1);
            $this->entityManager->flush();
            //Quentin ici tu met le mail a envoyer pour valider le paiement stp
        }
        //afficher infos commande
        return $this->render('order_validate/index.html.twig', [
            'order' => $order
        ]);
    }
}
