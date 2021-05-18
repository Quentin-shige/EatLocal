<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index(EntityManagerInterface $entityManager , Cart $cart, $reference)
    {
        $product_for_stripe = [];
        $YOUR_DOMAIN = 'https://127.0.0.1:8000';
        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }

        foreach ($order->getOrderDetails() as $details){
            // Faire payement Stripe
            $product_for_stripe[] = [
                'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $details->getProduct()->getPrice(),
                'product_data' => [
                        'name' => $details->getProduct()->getName(),
                        'images' => ["https://127.0.0.1:8000/"."uploads/".$details->getProduct()->getIllustration()],
                    ],
                ],
                'quantity' => $details->getQuantity(),
            ];
        }
        Stripe::setApiKey('sk_test_51IrmcmGC4UGSFjC3tYFF279rq7o2qk81u3WX3Xr4mQKhqmDRODBn8oX9h9G6vMxeosZYyJXSfy1hfd5YLVLQbZ8d00svljIqTF');
        header('Content-Type: application/json');
        $checkout_session = Session::create([
          'payment_method_types' => ['card'],
          'line_items' => [
            $product_for_stripe
            ],
          'mode' => 'payment',
          'success_url' => $YOUR_DOMAIN . '/success.html',
          'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]); 
        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;
    }
}
