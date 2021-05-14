<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'order')]
    public function index(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()->getAdresses()->getValues())
        {
            return $this->redirectToRoute('account_adress_add');
        }
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }
    #[Route('/commande/recap', name: 'order_recap')]
    public function add(Cart $cart, Request $request): Response
    {
        
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                
            $order = new Order();
            $order->setUser($this->getUser());

            }

        return $this->render('order/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }
}
