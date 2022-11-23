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
    public function view(CartRepository $cartRepository): Response
    {
        $user = $this->getUser();

        if (!$user)  {
            $this->addFlash("error", "Non connecté");

            return $this->redirectToRoute("app_login");
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
    public function add(Request $request, ProductRepository $productRepository, CartDetailRepository $cartDetailRepository, CartRepository $cartRepository): Response
    {
        $user = $this->getUser();

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

        $cartDetailFound = findCartDetailByProduct($user->getCart()->getCartDetails(), $product, $user);


        if($cartDetailFound) {
            $cartDetailFound->setQuantity($cartDetailFound->getQuantity() + $quantity);

            $cartDetailRepository->save($cartDetailFound, true);
        } else {
            $cartDetail = new CartDetail();

            $cartDetail->setProduct($product);

            $cartDetail->setQuantity($quantity);

            $cart = $user->getCart();

            $cart->addCartDetail($cartDetail);

            $cartDetailRepository->save($cartDetail, true);

            $cartRepository->save($cart, true);
        }
        



        $this->addFlash("success", "Le produit a était ajouté.");

        return $this->redirectToRoute("productview", [
            "id" => $id
        ]);
    }

    #[Route('/update', name: 'update')]
    public function update(Request $request, CartDetailRepository $cartDetailRepository): Response
    {
        $id = $request->query->get("id");
        $quantity = $request->query->get("quantity");
        $user = $this->getUser();

        $cartDetail = $cartDetailRepository->find($id);

        $cartDetails = $user->getCart()->getCartDetails();


        $idInCollection = findCartDetailId($cartDetails, $id);

        if(!isset($id) || !isset($quantity) || $quantity < 1 || !$cartDetail || !$this->getUser() || $idInCollection === null) {

            $this->addFlash("error", "Erreur lors de la demande");

            return $this->redirectToRoute("cartview",);
        }

        $cartDetail->setQuantity($quantity);

        $cartDetailRepository->save($cartDetail, true);

        $this->addFlash("success" ,"Les modification on était effectué");

        return $this->redirectToRoute("cartview");
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Request $request, CartDetailRepository $cartDetailRepository, $id): Response
    {
        $user = $this->getUser();


        if(!$user) {
            $this->addFlash("error", "Vous n'êtes pas connecté");

            return $this->redirectToRoute("app_login");
        }

        $cartDetails = $user->getCart()->getCartDetails();


        $idInCollection = findCartDetailId($cartDetails, $id);

        if($idInCollection === null) {
            $this->addFlash("error" ,"Erreur lors de la supression");

            return $this->redirectToRoute("cartview");
        }

        $cartDetail = $cartDetailRepository->find($id);


        $user->getCart()->removeCartDetail($cartDetail);

        $cartDetailRepository->save($cartDetail, true);

        $cartDetailRepository->remove($cartDetail, true);

        $this->addFlash("success", "Suppression reussie");
        return $this->redirectToRoute("cartview");
    }
}

function findCartDetailId($cartDetails, int $id) : int | null {
    foreach($cartDetails as $key => $cartDetail) {
        if($cartDetail->getId() == $id) return $key;
    }

    return null;
}

function findCartDetailByProduct($cartDetails, $product, $user) : CartDetail | null {
    foreach($user->getCart()->getCartDetails() as $cartDetail) {
        if($cartDetail->getProduct() == $product) {
            return $cartDetail;
        }
    }

    return null;
}
