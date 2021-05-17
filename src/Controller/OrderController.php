<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;


class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
    #[Route('/commande/recap', name: 'order_recap', methods:['POST'])]
    public function add(Cart $cart, Request $request): Response
    {
        
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
            $date = new DateTime();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('adresses')->getData();
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            $delivery_content = $delivery->getPhone();
            if ($delivery->getCompany())
            {
            $delivery_content = $delivery->getCompany();
            }
            $delivery_content = $delivery->getAdress();
            $delivery_content = $delivery->getPostal().' '.$delivery->getCity();
            $delivery_content = $delivery->getCountry();
            
            //Enregistrer la commande
            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            //Enregistrer les produits
            
            $product_for_stripe = [];

            foreach ($cart->getFull() as $product){
            $orderDetails = new OrderDetails();
            $orderDetails->setMyOrder($order);
            $orderDetails->setProduct($product['product']->getName());
            $orderDetails->setQuantity($product ['quantity']);
            $orderDetails->setPrice($product['product']->getPrice());
            $orderDetails->setTotal($product['product']->getPrice() * ($product ['quantity']));

            // $product_for_stripe[] = [
            //     'price_data' => [
            //     'currency' => 'eur',
            //     'unit_amount' => $product['product']->getPrice(),
            //     'product_data' => [
            //             'name' => $product['product']->getName(),
            //             'images' => [$YOUR_DOMAIN."uploads/".$product['product']->getIllustration()],
            //         ],
            //     ],
            //     'quantity' => $product ['quantity'],
            // ];
            }

            $this->entityManager->flush();

                // Stripe::setApiKey('sk_test_51IrmcmGC4UGSFjC3tYFF279rq7o2qk81u3WX3Xr4mQKhqmDRODBn8oX9h9G6vMxeosZYyJXSfy1hfd5YLVLQbZ8d00svljIqTF');
                // $YOUR_DOMAIN = 'https://127.0.0.1:8000';
                // $checkout_session = Session::create([
                // 'payment_method_types' => ['card'],
                // 'line_items' => [[
                //     'price_data' => [
                //     'currency' => 'usd',
                //     'unit_amount' => 2000,
                //     'product_data' => [
                //         'name' => 'Stubborn Attachments',
                //         'images' => [$YOUR_DOMAIN."uploads/".$product->getIllustration()],
                //     ],
                //     ],
                //     'quantity' => 1,
                // ]],
                // 'mode' => 'payment',
                // 'success_url' => $YOUR_DOMAIN . '/success.html',
                // 'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
                // ]);
                // echo json_encode(['id' => $checkout_session->id]);
                
                // dump($checkout_session->id);
                // dd($checkout_session);

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' =>$carriers,
                'delivery' => $delivery_content
            ]);
            }
            return $this->RedirectToRoute('cart');
    }

    

}
