<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
#[Route('/panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig');
    }

#[Route('/cart/add/{id}', name: 'addtocart')]
    public function add(Cart $cart,$id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

#[Route('/cart/remove/{id}', name: 'removecart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }
}
