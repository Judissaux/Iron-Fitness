<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/articles', name: 'app_blog')]
    public function index(ArticleRepository $article): Response   
    {
        return $this->render('articles/index.html.twig',
        ['articles' => $article->findBy([],['createdAt' => 'DESC'])]);
    }

    #[Route('/articles/{slug}', name: 'app_show')]
    public function show(): Response   
    {
        return $this->render('articles/show.html.twig');
    }
}
