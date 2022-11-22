<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/cart', name: 'cart')]
class CartController extends AbstractController
{
    #[Route('/view', name: 'view')]
    public function view(UserInterface $user): Response
    {

        if (!$user)  {
            $this->addFlash("error", "Non connecté");

            return $this->redirectToRoute("app_home");
        }


        $cart = $user->getCart()->getCartDetails();



        return $this->render('cart/cart.html.twig', [
            'controller_name' => 'CartController',
            "cart" => $cart

        ]);
    }

    #[Route('/add', name: 'cartCreate')]
    public function create(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/update', name: 'cartUpdate')]
    public function update(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/delete', name: 'cartDelete')]
    public function delete(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
