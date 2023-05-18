<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/articles', name: 'app_blog')]
    public function index(ArticleRepository $article, Request $request, PaginatorInterface $paginator): Response   
    {
        $donnees =  $article->findBy([],['createdAt' => 'DESC']);

        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('articles/index.html.twig', 
            compact('articles')
        );
    }
    
    // En appelant l'entité article on récupére l'article si il existe sinon on renvoie l'utilisateur sur la page d'accueil
    #[Route('/articles/{slug}', name: 'app_show')]
    public function show(?Article $article,ArticleRepository $articleRepo): Response   
    {
        if(!$article) {
           return $this->redirectToRoute('app_home');
        }
        $slug = $article->getSlug();
        return $this->render('articles/show.html.twig',[
            'article' => $article,
            'arts' => $articleRepo->find3LastArticles($slug)
             ]);
    }

}
