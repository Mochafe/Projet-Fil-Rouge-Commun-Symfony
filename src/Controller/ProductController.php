<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/product', name: 'product')]
class ProductController extends AbstractController
{

    #[Route('view/{id}', name: 'view')]
    public function view(ProductRepository $productRepository, int $id): Response
    {

        $product = $productRepository->find($id);

        return $this->render('product/product.html.twig', [
            'product' => $product
        ]);
    }
    #[Route('/{category}', name: 'category')]
    public function index(Category $category): Response
    {

        $products = $category->getProducts();

        return $this->render('product/products.html.twig', [
            'products' => $products,
            'category' => $category
        ]);
    }

   
}
