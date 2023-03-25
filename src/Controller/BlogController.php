<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $article): Response   
    {
        return $this->render('autresPages/blog.html.twig',
        ['articles' => $article->findBy([],['created_at' => 'DESC'])]);
    }
}
