<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        // dd($posts);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

     /**
     * Route("/post/{id}", name="post_view", methods={"GET"}, requirements={"id"="\d+"})
     * @Route("/post/{slug}", name="post_view", methods={"GET"})
     */
    public function post(Post $post): Response
    {
        return $this->render('post/post.html.twig', [
                'post' => $post
        ]);
    }

}
