<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', name: 'product')]
class ProductController extends AbstractController
{
    #[Route('/{id}', name: 'view')]
    public function view(ProductRepository $productRepository, int $id): Response
    {
        
        $product = $productRepository->find($id);

        dd($product);

        return $this->render('product/product.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/{id}', name: 'view')]
    public function create(ProductRepository $productRepository, int $id): Response
    {
        
        $product = $productRepository->find($id);

        return $this->render('product/product.html.twig', [
            'product' => $product
        ]);
    }
}
