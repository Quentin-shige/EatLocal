<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
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
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }

        foreach ($order->getOrderDetails()->getValues() as $details){
            $product_object = $entityManager->getRepository(Product::class)->findOneByName($details->getProduct());
            // Faire payement Stripe
            $product_for_stripe[] = [
                'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $product_object ->getPrice(),
                'product_data' => [
                        'name' => $details->getProduct(),
                        'images' => ["https://127.0.0.1:8000/"."uploads/".$product_object->getIllustration()],
                    ],
                ],
                'quantity' => $details->getQuantity(),
            ];
        }

        $product_for_stripe[] = [
            'price_data' => [
            'currency' => 'eur',
            'unit_amount' => $order->getCarrierPrice(),
            'product_data' => [
                    'name' => $order->getCarrierName(),
                ],
            ],
            'quantity' => 1,
        ];


        Stripe::setApiKey('sk_test_51IrmcmGC4UGSFjC3tYFF279rq7o2qk81u3WX3Xr4mQKhqmDRODBn8oX9h9G6vMxeosZYyJXSfy1hfd5YLVLQbZ8d00svljIqTF');
        header('Content-Type: application/json');
        $checkout_session = Session::create([
          'customer_email' => $this->getUser()->getEmail(),
          'payment_method_types' => ['card'],
          'line_items' => [
            $product_for_stripe
            ],
          'mode' => 'payment',
          'success_url' => $YOUR_DOMAIN.'/commande/merci/{CHECKOUT_SESSION_ID}',
          'cancel_url' => $YOUR_DOMAIN.'/erreur/{CHECKOUT_SESSION_ID}',
        ]); 

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;
    }
}
