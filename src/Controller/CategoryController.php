<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;

#[Route('/category', name: 'category')]

class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index( CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();
        
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{category}', name: 'subcategory')]
    public function sub( Category $category): Response
    {
     
      
        return $this->render('category/sub.html.twig', [
            'categories' => $category->getChilds(),
            "category" => $category
        ]);
    }
}
