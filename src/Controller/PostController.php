<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController HOME',
        ]);
    }

     /**
     * @Route("/post/{id}", name="post_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function post($id): Response
    {
        return $this->render('post/post.html.twig', [
            'post' => [
                'title' => 'Le titre de l\'article',
                'content' => 'Le contenu de l\'article',
                'createdAt' => '09/02/2021',
            ],
        ]);
    }
}
