<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartDetail;
use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\CartDetailRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cart', name: 'cart')]
class CartController extends AbstractController
{
    #[Route('/view', name: 'view')]
    public function view(UserInterface $user, CartRepository $cartRepository): Response
    {

        if (!$user)  {
            $this->addFlash("error", "Non connecté");

            return $this->redirectToRoute("app_home");
        } 

        if(!$user->getCart()) {
            $cart = new Cart();
            $user->setCart($cart);
            $cartRepository->save($cart, true);
        }

        $cart = $user->getCart()->getCartDetails();

        return $this->render('cart/cart.html.twig', [
            'controller_name' => 'CartController',
            "cartDetails" => $cart

        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, ProductRepository $productRepository, CartDetailRepository $cartDetailRepository, CartRepository $cartRepository, UserInterface $user): Response
    {

       if(!$user) {
            $this->addFlash("error", "Vous n'êtes pas connecté");

            return $this->redirectToRoute("app_login");
       }

       $id = $request->request->get("id");
       $product = $productRepository->find($id);



       if(!$product) {
        $this->addFlash("error", "Le produit n'existe pas.");

        return $this->redirectToRoute("app_home");
        }

        $quantity = $request->request->get("quantity");


        if($quantity < 1) {
        $this->addFlash("error", "Quantité invalide");

        return $this->redirectToRoute("productview", [
            "id" => $id
        ]);
        }

        if(!$user->getCart()) {
            $cart = new Cart();
            $user->setCart($cart);
            $cartRepository->save($cart, true);
        }

        $cartDetail = new CartDetail();

        $cartDetail->setProduct($product);

        $cartDetail->setQuantity($quantity);

        $cart = $user->getCart();

        $cart->addCartDetail($cartDetail);

        $cartDetailRepository->save($cartDetail, true);

        $cartRepository->save($cart, true);



        $this->addFlash("success", "Le produit a était ajouté.");

        return $this->redirectToRoute("productview", [
            "id" => $id
        ]);
    }

    #[Route('/update', name: 'update')]
    public function update(Request $request, ProductRepository $productRepository): Response
    {
        $id = $request->request->get("id");
        $quantity = $request->request->get("quantity");

        if(!isset($id) || !isset($quantity) || $quantity < 1 || $productRepository->find($id)) {
            $this->addFlash("error", "Erreur lors de la demande");

            return $this->redirectToRoute("cartview");
        }

        $this->addFlash("success" ,"Les modification on était effectué");

        return $this->redirectToRoute("cartview");
    }

    #[Route('/delete', name: 'delete')]
    public function delete(Request $request): Response
    {
        $id = $request->request->get("id");

        $this->addFlash("success", "Suppression reussie");
        return $this->redirectToRoute("cartview");
    }
}
